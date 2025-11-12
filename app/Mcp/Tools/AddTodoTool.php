<?php

namespace App\Mcp\Tools;

use App\Models\Todo;
use Generator;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\Title;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

#[Title('Add Todo')]
class AddTodoTool extends Tool
{
    /**
     * A description of the tool.
     */
    public function description(): string
    {
        return 'Creates a todo item with the given title.';
    }

    /**
     * The input schema of the tool.
     */
    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        $schema->string('title')
            ->description('The title of the todo item.')
            ->required();

        return $schema;
    }

    /**
     * Execute the tool call.
     *
     * @return ToolResult|Generator
     */
    public function handle(array $arguments): ToolResult|Generator
    {
        $title = trim($arguments['title'] ?? '');

        if (empty($title)) {
            return ToolResult::text('Missing title.');
        }

        $todo = Todo::create([
            'title' => $title,
            'completed' => false,
        ]);

        $todos = Todo::orderBy('created_at', 'desc')->get();

        // Return structured data as JSON for the UI to consume
        return ToolResult::json([
            'message' => "Added \"{$todo->title}\".",
            'tasks' => $todos->map(fn($t) => [
                'id' => $t->id,
                'title' => $t->title,
                'completed' => $t->completed,
            ])->toArray(),
        ]);
    }
}

<?php

namespace App\Mcp\Tools;

use App\Models\Todo;
use Generator;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\Title;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

#[Title('Complete Todo')]
class CompleteTodoTool extends Tool
{
    /**
     * A description of the tool.
     */
    public function description(): string
    {
        return 'Marks a todo item as completed by ID.';
    }

    /**
     * The input schema of the tool.
     */
    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        $schema->string('id')
            ->description('The ID of the todo item to complete.')
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
        $id = $arguments['id'] ?? null;

        if (empty($id)) {
            return ToolResult::text('Missing todo ID.');
        }

        $todo = Todo::find($id);

        if (!$todo) {
            return ToolResult::error("Todo {$id} was not found.");
        }

        $todo->update(['completed' => true]);

        $todos = Todo::orderBy('created_at', 'desc')->get();

        return ToolResult::json([
            'message' => "Completed \"{$todo->title}\".",
            'tasks' => $todos->map(fn($t) => [
                'id' => $t->id,
                'title' => $t->title,
                'completed' => $t->completed,
            ])->toArray(),
        ]);
    }
}

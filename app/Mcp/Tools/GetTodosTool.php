<?php

namespace App\Mcp\Tools;

use App\Models\Todo;
use Generator;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\Title;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

#[Title('Get Todos')]
class GetTodosTool extends Tool
{
    /**
     * A description of the tool.
     */
    public function description(): string
    {
        return 'Retrieves all todo items from the list.';
    }

    /**
     * The input schema of the tool.
     */
    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        // No input needed for this tool
        return $schema;
    }

    /**
     * Execute the tool call.
     *
     * @return ToolResult|Generator
     */
    public function handle(array $arguments): ToolResult|Generator
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();

        return ToolResult::json([
            'message' => 'Retrieved all todos.',
            'tasks' => $todos->map(fn($t) => [
                'id' => $t->id,
                'title' => $t->title,
                'completed' => $t->completed,
            ])->toArray(),
        ]);
    }
}

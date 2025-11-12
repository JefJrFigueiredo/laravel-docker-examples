<?php

namespace App\Mcp\Servers;

use App\Mcp\Resources\TodoWidgetResource;
use App\Mcp\Tools\AddTodoTool;
use App\Mcp\Tools\CompleteTodoTool;
use App\Mcp\Tools\GetTodosTool;
use Laravel\Mcp\Server;

class TodoServer extends Server
{
    public string $serverName = 'Todo App';

    public string $serverVersion = '1.0.0';

    public string $instructions = 'This server provides a Todo List application with the ability to create, view, and complete todo items.';

    public array $tools = [
        GetTodosTool::class,
        AddTodoTool::class,
        CompleteTodoTool::class,
    ];

    public array $resources = [
        TodoWidgetResource::class,
    ];

    public array $prompts = [
        // No prompts for this simple app
    ];
}

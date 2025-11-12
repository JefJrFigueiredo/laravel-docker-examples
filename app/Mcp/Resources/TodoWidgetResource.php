<?php

namespace App\Mcp\Resources;

use Laravel\Mcp\Server\Resource;

class TodoWidgetResource extends Resource
{
    protected string $description = 'The Todo List web component UI that displays and manages todos.';

    /**
     * Return the resource URI.
     */
    public function uri(): string
    {
        return 'ui://widget/todo.html';
    }

    /**
     * Return the resource MIME type.
     */
    public function mimeType(): string
    {
        return 'text/html';
    }

    /**
     * Return the resource contents.
     */
    public function read(): string
    {
        return view('mcp.todo-widget')->render();
    }
}

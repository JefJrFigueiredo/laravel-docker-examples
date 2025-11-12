<?php

use App\Mcp\Servers\TodoServer;
use Laravel\Mcp\Server\Facades\Mcp;

// Register the Todo Server as a web-accessible MCP server at root
Mcp::web('/', TodoServer::class); // Available at /mcp/

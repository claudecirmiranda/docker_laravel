<?php

return [
    "labels" => [
        "search" => "Buscar",
        "base_url" => "URL Base",
    ],

    "auth" => [
        "none" => "Esta API não requer autenticação.",
        "instruction" => [
            "query" => <<<TEXT
                Para autenticar as requisições, inclua um parâmetro de query **`:parameterName`** na requisição.
                TEXT,
            "body" => <<<TEXT
                Para autenticar as requisições, inclua um parâmetro **`:parameterName`** no corpo da requisição.
                TEXT,
            "query_or_body" => <<<TEXT
                Para autenticar as requisições, inclua um parâmetro **`:parameterName`** ou na query string ou no corpo da requisição.
                TEXT,
            "bearer" => <<<TEXT
                Para autenticar as requisições, inclua um header **`Authorization`** com o valor **`"Bearer :placeholder"`**.
                TEXT,
            "basic" => <<<TEXT
                Para autenticar as requisições, inclua um header **`Authorization`** no formato **`"Basic {credentials}"`**.
                O valor de `{credentials}` deve ser seu username/id e sua senha, concatenados com dois pontos (:),
                e então codificados em base64.
                TEXT,
            "header" => <<<TEXT
                Para autenticar as requisições, inclua um header **`:parameterName`** com o valor **`":placeholder"`**.
                TEXT,
        ],
        "details" => <<<TEXT
            Todos os endpoints que requerem autenticação são marcados com o selo `requer autenticação` na documentação abaixo.
            TEXT,
    ],

    "headings" => [
        "introduction" => "Introdução",
        "auth" => "Autenticando requisições",
    ],

    "endpoint" => [
        "request" => "Requisição",
        "headers" => "Headers",
        "url_parameters" => "Parâmetros de URL",
        "body_parameters" => "Parâmetros de Corpo",
        "query_parameters" => "Parâmetros de Query",
        "response" => "Resposta",
        "response_fields" => "Campos da Resposta",
        "example_request" => "Exemplo de requisição",
        "example_response" => "Exemplo de resposta",
        "responses" => [
            "binary" => "Dados binários",
            "empty" => "Resposta vazia",
        ],
    ],

    "try_it_out" => [
        "open" => "Testar agora ⚡",
        "cancel" => "Cancelar 🛑",
        "send" => "Enviar Requisição 💥",
        "loading" => "⏱ Enviando...",
        "received_response" => "Resposta recebida",
        "request_failed" => "Requisição falhou com erro",
        "error_help" => <<<TEXT
            Dica: Verifique se você está devidamente conectado à rede.
            Se você for o responsável pela manutenção desta API, verifique se sua API está em execução e se você habilitou o CORS.
            Você pode verificar o console do Dev Tools para informações de depuração.
            TEXT,
    ],

    "links" => [
        "postman" => "Ver coleção do Postman",
        "openapi" => "Ver especificação OpenAPI",
    ],
];

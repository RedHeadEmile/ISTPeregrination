<?php

namespace ISTPeregrination\Controllers;

use ISTPeregrination\Services\Migration\MigrationService;

class MigrationController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function get(): void
    {
        $this->requireAuth();
        try {
            MigrationService::getInstance()->migrate();
        }
        catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage()
            ]);
        }
    }
}
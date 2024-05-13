<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReportServices {
  /**
   * Report error
   *
   * @param object $error
   * @param string|null $controller
   * @param string|null $function
   * @return void
   */
  static function reportError(object $error, string $controller = null, string $function = null): void
  {
      Log::info('====================== ERROR ======================');
      Log::info('DateTime: ' . Carbon::now()->format('Y-m-d H:i:s'));
      Log::info('File: ' . $error->getFile());
      Log::info('Message: ' . $error->getMessage());
      Log::info('Line: ' . $error->getLine());
      Log::info('Controller: ' . $controller ?? 'Not specified');
      Log::info('Function: ' . $function ?? 'Not specified');
      Log::info('===================================================');
  }
}
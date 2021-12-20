<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Uma lista dos tipos de exceção que não são relatados.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registre os chullbacks de manuseio de exceção para o aplicativo.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if($this->isHttpException($e))
            {
                switch (intval($e->getStatusCode())) {
                    // not found
                    case 404:
                        return redirect()->route('404');
                        break;
                    // internal error
                    case 500:
                        return redirect()->route('');
                        break;
        
                    default:
                        return $this->renderHttpException($e);
                        break;
                }
            }

            // return parent::render($e);  
        });
    }
}

<?php

namespace App\Exception;

use Swoft\Bean\Annotation\ExceptionHandler;
use Swoft\Bean\Annotation\Handler;
use Swoft\Exception\RuntimeException;
use Exception;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\Exception\BadMethodCallException;

/**
 * the handler of global exception
 *
 * @ExceptionHandler()
 * @uses      Handler
 * @version   2018年01月14日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class SwoftExceptionHandler
{
    /**
     * @Handler(Exception::class)
     *
     * @param Response   $response
     * @param \Throwable $throwable
     *
     * @return Response
     */
    public function handlerException(Response $response, \Throwable $throwable)
    {
        $file      = $throwable->getFile();
        $code      = $throwable->getCode();
        $exception = $throwable->getMessage();

        return $response->json([$exception, $file, $code]);
    }

    /**
     * @Handler(RuntimeException::class)
     *
     * @param Response   $response
     * @param \Throwable $throwable
     *
     * @return Response
     */
    public function handlerRuntimeException(Response $response, \Throwable $throwable)
    {
        $file      = $throwable->getFile();
        $code      = $throwable->getCode();
        $exception = $throwable->getMessage();

        return $response->json([$exception, 'runtimeException']);
    }

    /**
     * @Handler(BadMethodCallException::class)
     *
     * @param Request    $request
     * @param Response   $response
     * @param \Throwable $throwable
     *
     * @return Response
     */
    public function handlerViewException(Request $request, Response $response, \Throwable $throwable)
    {
        $name  = $throwable->getMessage(). $request->getUri()->getPath();
        $notes = [
            'New Generation of PHP Framework',
            'Hign Performance, Coroutine and Full Stack',
        ];
        $links = [
            [
                'name' => 'Home',
                'link' => 'http://www.swoft.org',
            ],
            [
                'name' => 'Documentation',
                'link' => 'http://doc.swoft.org',
            ],
            [
                'name' => 'Case',
                'link' => 'http://swoft.org/case',
            ],
            [
                'name' => 'Issue',
                'link' => 'https://github.com/swoft-cloud/swoft/issues',
            ],
            [
                'name' => 'GitHub',
                'link' => 'https://github.com/swoft-cloud/swoft',
            ],
        ];
        $data  = compact('name', 'notes', 'links');

        return view('exception/index', $data);
    }

}
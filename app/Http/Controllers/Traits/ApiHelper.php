<?php
/**
 * Api 接口封装
 */

namespace App\Http\Controllers\Traits;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ApiHelper
{
    public function defaultApi($content = [], $location = null)
    {
        $rtn = [
            'status' => 0,
            'data'=> [],
            'msg' => '',
        ];
        $rtn = array_merge($rtn, $content);
        $response = new Response($rtn);

        // 201
        $response->setStatusCode(Response::HTTP_CREATED);
        if (! is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * 响应创建的响应并关联位置（如果提供）。
     * Respond with a created response and associate a location if provided.
     *
     * @param null        $content  响应数据
     * @param null|string $location 重定向
     * @return Response
     */
    public function created($content = null, $location = null)
    {
        $response = new Response($content);
        // 201
        $response->setStatusCode(Response::HTTP_CREATED);
        if (! is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * 回应已接受的回复并关联位置和/或内容（如果提供）。
     * Respond with an accepted response and associate a location and/or content if provided.
     *
     * @param null|string $location
     * @param mixed       $content
     *
     * @return Response
     */
    public function accepted($location = null, $content = null)
    {
        $response = new Response($content);
        // 202
        $response->setStatusCode(Response::HTTP_ACCEPTED);

        if (! is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * 回复无内容回复。
     * Respond with a no content response.
     *
     * @return Response
     */
    public function noContent()
    {
        $response = new Response(null);
        // 204
        return $response->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * 返回json响应。
     * Return a json response.
     * @param array $data
     * @param array $headers
     * @return Response
     */
    public function json($data = [], array $headers = [])
    {
        return new Response(compact('data'),Response::HTTP_OK,$headers);
    }

    /**
     * 将项目绑定到apiResource并开始构建响应。
     *  Bind an item to a apiResource and start building a response.
     * @param       $data
     * @param       $resourceClass
     * @param array $meta
     * @return mixed
     */
    public function item($data, $resourceClass, $meta = [])
    {
        if(is_null($data)){
            return compact('data');
        }
        if (count($meta)) {
            return (new $resourceClass($data))->additional($meta);
        }
        return new $resourceClass($data);
    }

    /**
     * 将集合绑定到apiResource并开始构建响应。
     * Bind a collection to a apiResource and start building a response.
     *
     * @param       $data
     * @param       $resourceClass
     * @param array $meta
     * @return Response
     */
    public function collection($data, $resourceClass, $meta = [])
    {
        if (count($meta)) {
            return $resourceClass::collection($data)->additional($meta);
        }
        return $resourceClass::collection($data);
    }

    /**
     * 将 paginator 绑定到 apiResource 并开始构建响应。
     * Bind a paginator to a apiResource and start building a response.
     *
     * @param Paginator $paginator
     * @param           $resourceClass
     * @param array     $meta
     * @return Response
     */
    public function paginator(Paginator $paginator, $resourceClass, array $meta = [])
    {
        return $this->collection($paginator,$resourceClass,$meta);
    }

    /**
     * 返回错误响应。
     * Return an error response.
     *
     * @param string $message
     * @param        $statusCode
     * @return void
     */
    public function error($message, $statusCode=400)
    {
        // return new Response(compact('message','status_code'),$status_code,$header);
        throw new HttpException($statusCode, $message);
    }

    /**
     * 返回404未找到错误。
     * Return a 404 not found error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorNotFound($message = 'Not Found')
    {
        // 404
        $this->error($message, Response::HTTP_NOT_FOUND);
    }

    /**
     * 返回400错误请求错误。
     * Return a 400 bad request error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorBadRequest($message = 'Bad Request')
    {
        // 400
        $this->error($message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * 返回403禁止的错误。
     * Return a 403 forbidden error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorForbidden($message = 'Forbidden')
    {
        // 403
        $this->error($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * 返回500内部服务器错误。
     * Return a 500 internal server error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorInternal($message = 'Internal Error')
    {
        // 500
        $this->error($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * 返回401未经授权的错误。
     * Return a 401 unauthorized error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        // 401
        $this->error($message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * 返回405方法不允许错误。
     * Return a 405 method not allowed error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        // 405
        $this->error($message, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}

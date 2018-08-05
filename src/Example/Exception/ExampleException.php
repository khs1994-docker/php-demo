<?php

declare(strict_types=1);

namespace Example\Exception;

class ExampleException extends \Exception
{
    /**
     * 报告异常
     *
     * @return void
     */
    public function report(){

    }

    /**
    * 将异常渲染到 HTTP 响应中。
    *
    * @param  \Illuminate\Http\Request
    * @return void
    */
    public function render(Request $request){
        return response(...);
    }
}

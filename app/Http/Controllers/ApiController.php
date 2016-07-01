<?php
namespace App\Http\Controllers;
/**
* Class ApiController
*
* @package App\Http\Controllers
*
* @SWG\Swagger(
*     basePath="/api",
*     host="",
*     schemes={"http"},
*     @SWG\Info(
*         version="1.0",
*         title="Notes API",
*         description="API created for censornet",
*         @SWG\Contact(name="Adrian Tamas", url="e-f.ro"),
*     ),
*     @SWG\Definition(
*         definition="Error",
*         required={"code", "message"},
*         @SWG\Property(
*             property="code",
*             type="integer",
*             format="int32"
*         ),
*         @SWG\Property(
*             property="message",
*             type="string"
*         )
*     )
* )
*/
class ApiController extends Controller
{
}

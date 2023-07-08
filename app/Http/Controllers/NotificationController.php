<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Helpers\Base64;
use App\Helpers\DateHelper;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function getList(Request $request) {

        try {

            $paginate = $request->input('paginate') ? $request->input('paginate') : 5;

            $results = $this->notificationService->getList($paginate, $request->input('user_id'), $request->input('order'), $request->input('active'));

            foreach ($results as $index => $result) {
                $result->user;

                $result['creator'] = [

                    'user_id' => Base64::id_encode($result['user']['id']),
                    'fullname' => $result['user']['fullname'],
                    'sur_name' => $result['user']['sur_name'],
                    'given_name' => $result['user']['given_name'],
                    'email' => $result['user']['email'],
                    'class' => $result['user']['class'],
                    'stu_code' => $result['user']['stu_code'],
                    'role' => $result['user']['role'],
                    'avatar' => $result['user']['avatar'],

                ];

                unset($result['user']);
                unset($result['user_id']);

                $result['created_time'] = DateHelper::make($result['created_time']);
                $result['updated_time'] = DateHelper::make($result['updated_time']);
            }
            
            return response($results);
        } catch (\Throwable $th) {
            //throw $th;
            return \response([
                'error' => true,
                'msg' => 'Params error',
                'msg_vi' => 'Có thể lỗi do sai dữ liệu tham số truyền vào'
            ], 500);
            
        }

    }

    public function getBySlug(Request $request) {
        
        $result = $this->notificationService->getBySlug(
            $request->input('slug')
        );

        $result->user;
        $result['creator'] = [

            'user_id' => Base64::id_encode($result['user']['id']),
            'fullname' => $result['user']['fullname'],
            'sur_name' => $result['user']['sur_name'],
            'given_name' => $result['user']['given_name'],
            'email' => $result['user']['email'],
            'class' => $result['user']['class'],
            'stu_code' => $result['user']['stu_code'],
            'role' => $result['user']['role'],
            'avatar' => $result['user']['avatar'],

        ];

        unset($result['user']);
        unset($result['user_id']);

        $result['created_time'] = DateHelper::make($result['created_time']);
        $result['updated_time'] = DateHelper::make($result['updated_time']);

        return response($result);
        try {
            

        } catch (\Throwable $th) {
            return \response([
                'error' => true,
                'msg' => 'Params error',
                'msg_vi' => 'Có thể lỗi do sai dữ liệu tham số truyền vào'
            ], 500);
        }
    }
}
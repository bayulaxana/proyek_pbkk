<?php

namespace ServiceLaundry\Dashboard\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Dashboard\Forms\Web\UserForm;
use ServiceLaundry\Order\Models\Web\Orders;
use ServiceLaundry\Order\Models\Web\Service;
use ServiceLaundry\Dashboard\Models\Web\Users;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class IndexController extends SecureController
{
    public function initialize()
    {
        $this->memberExecutionRouter();
        $this->setFlashSessionDesign();
    }

    public function indexAction()
    {
        $this->response->redirect('/dashboard/activity');
    }

    public function activityAction()
    {
        // Find order by the user id
        $orders = Orders::find(
            [
                'conditions' => 'user_id = :user_id:',
                'bind' => [
                    'user_id' => $this->session->auth['id'],
                ]
            ]
        )->toArray();

        // Calculation
        $orderCount     = count($orders);
        $activeOrder    = 0;
        $finishedOrder  = 0;
        $waitingOrder   = 0;
        foreach ($orders as $order) {
            if ($order['order_status'] == 'On Process') {
                $activeOrder++;
            }
            else if ($order['order_status'] == 'Finished') {
                $finishedOrder++;
            }
            else if ($order['order_status'] == 'Waiting') {
                $waitingOrder++;
            }
        }
        
        // Send it to view
        $this->view->setVar('orderDetail', [
            'orderCount' => $orderCount,
            'activeOrder' => $activeOrder,
            'finishedOrder' => $finishedOrder,
            'waitingOrder' => $waitingOrder,
        ]);
    }

}
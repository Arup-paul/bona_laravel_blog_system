<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Subscriber;

class SubscriberController extends Controller {
    public function index() {
        $data                = [];
        $data['subscribers'] = Subscriber::latest()->get();
        return view( 'admin.subscriber.index', $data );
    }
    public function destroy( $id ) {
        $subscriber = Subscriber::find( $id );
        $subscriber->delete();
        session()->flash( 'type', 'success' );
        session()->flash( 'message', 'Subscriber Deleted' );
        return redirect()->back();
    }
}

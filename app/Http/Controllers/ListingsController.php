<?php

namespace App\Http\Controllers;

use App\Listing;
use Auth;
use Validator;

use Illuminate\Http\Request;

class ListingsController extends Controller
{
    //コンストラクタ（このクラスが呼ばれると最初にこの処理をする）
    public function __construct()
    {
        //ログインしていない場合、ログインページに遷移する（この処理を消すとログインしていない場合もページを表示する）
        $this->middleware('auth');
    }

    public function index()
    {
        //Listingモデルを介してlistingsテーブルからデータを取得
        $listings = Listing::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'asc')
            //クエリビルダとしていろんな制約をするときは、最後に get メソッドで結果を取得する
            ->get();

        // テンプレート「listing/index.blade.php」を表示する
        return view ('listing/index', ['listings' => $listings]);
    }
}

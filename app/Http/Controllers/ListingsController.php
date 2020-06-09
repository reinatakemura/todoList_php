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
        //参考：https://laraweb.net/knowledge/1345/
        return view('listing/index', ['listings' => $listings]);
    }

    public function new()
    {
        // テンプレート「listing/new.blade.php」を表示する
        return view('listing/new');
    }

    public function store(Request $request)
    {
        //バリデーション（入力値チェック）
        //リスト新規作成画面から入力された値に対して入力チェックを行う
        //下記ではリスト名に対し「入力必須」と「255文字以下」かどうか
        $validator = Validator::make($request->all() , ['list_name' => 'required|max:255', ]);

        //バリデーションの結果がエラーの場合
        if ($validator->fails())
        {
            //バリデーションエラーの場合は元の画面へ戻るよう画面遷移
            //戻る際、バリデーションエラーの内容とフォームに入力された値も渡す
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // Listingモデル作成
        $listings = new Listing;
        $listings->title = $request->list_name;
        $listings->user_id = Auth::user()->id;

        $listings->save();
        // 「/」ルートにリダイレクト
        return redirect('/');
    }

    public function edit($listing_id)
    {
        $listing = Listing::find($listing_id);
        //テンプレート「listing/edit.blade.php」を表示する
        return view('listing/edit', ['listing' => $listing]);
    }

    public function update(Request $request)
    {
        //バリデーション（入力値チェック）
        $validator = Validator::make($request->all() , ['list_name' => 'required|max:255', ]);

        //バリデーションの結果がエラーの場合
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $listing = Listing::find($request->id);
        $listing->title = $request->list_name;
        $listing->save();
        return redirect('/');
    }

    public function destroy($listing_id)
    {
        $listing = Listing::find($listing_id);
        $listing->delete();
        return redirect('/');
    }
}

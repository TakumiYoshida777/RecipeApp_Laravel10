<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class RecipeController extends Controller
{

    public function home()
    {
        //新着のレシピを新しい順に３件取得する
        $recipes = Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.image', 'recipes.created_at')
            ->join('users', 'users.id', '=', 'recipes.user_id')
            ->orderby('recipes.created_at', 'desc')
            ->limit(3)
            ->get();
        // dd($recipes);

        $popular = Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.image', 'recipes.views', 'recipes.created_at')
            ->join('users', 'users.id', '=', 'recipes.user_id')
            ->orderby('recipes.views', 'desc')
            ->limit(2)
            ->get();
        // dd($popular);

        return view('home', compact('recipes', 'popular'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        // dd($filters);
        $query = Recipe::query()->select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.image', 'users.name'
        // , DB::raw('AVG(reviews.rating) as rating')
        )
            ->join('users', 'users.id', '=', 'recipes.user_id')
            ->leftJoin('reviews', 'reviews.recipe_id', '=', 'recipes.id')
            // ->groupBy('recipes.id')
            ->orderBy('recipes.created_at', 'desc');

        if( !empty($filters) ) {
                // もしカテゴリーが選択されていたら
            if( !empty($filters['categories']) ) {
                // カテゴリーで絞り込み選択したカテゴリーIDが含まれているレシピを取得
                $query->whereIn('recipes.category_id', $filters['categories']);
            }
            if( !empty($filters['rating']) ) {
                // 評価で絞り込み
                // $query->havingRaw('AVG(reviews.rating) >= ?', [$filters['rating']])->orderBy('rating', 'desc');
                // TODO:エラーでできなかった：セクション7→49
            }
            if ($filters['title']) {
                // キーワード検索　※部分一致検索
                $query->where('recipes.title', 'like', '%'. $filters['title']. '%');
            }
        }
        $recipes = $query->paginate(5);
        // dd($recipes);

        $categories = Category::all();

        return view('recipes.index', compact('recipes', 'categories','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('recipes.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $posts = $request->all();
        $uuid = Str::uuid()->toString();
        // dd($posts);
        $steps =[];

        foreach($posts['steps'] as $key => $step) {
            $steps[$key] = [
                'recipe_id' => $uuid,
                'step_number' => $key + 1,
                'description' => $step
            ];
        }

        // dd($steps);

        Recipe::insert([
            'id' => $uuid,
            'title' => $posts['title'],
            'description' => $posts['description'],
            'user_id' => Auth::id(),
            'category_id' => $posts['category'],
        ]);
        // $dir = 'images';
        // $imagePath = $posts['image']->store('public/'. $dir);
        // dd( $imagePath);
        // 画像の保存に成功したら、$imagePath をデータベースに保存するなどの処理を行う

        Step::insert($steps);

        return redirect()->route('recipe.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //リレーションで材料とステップを取得 ※リレーションプロパティに格納
        $recipe = Recipe::with(['ingredients', 'steps', 'reviews.user','user'])
        ->where('recipes.id', $id)
        ->first();

        //viewsカラムの値を１つずふやす。今回は閲覧数（PV）として活用
        $recipe_record = Recipe::find($id);
        $recipe_record->increment('views');
        // dd($recipe);

        return view('recipes.show',compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

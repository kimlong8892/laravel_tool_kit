<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface {
    public function getListInAdmin(): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        $perPage = config('custom.post')['per_page'] ?? 10;
        return Post::with(['Admin'])
            ->paginate($perPage);
    }

    public function store($data): int {
        $post = new Post();
        $post->fill($data);
        $post->save();

        return $post->getAttribute('id');
    }

    public function update($id, $data): int {
        $post = Post::find($id);
        $post->fill($data);
        $post->save();

        return $post->getAttribute('id');
    }

    public function getDetail($id) {
        return Post::find($id);
    }

    public function destroy($id): int {
        DB::table('posts')->find($id)->delete();

        return $id;
    }
}

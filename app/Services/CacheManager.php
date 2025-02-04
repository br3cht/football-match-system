<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheManager
{
    public function __construct(
        private string $prefix  = 'app'
    ) { }

    public function gerateKey(string $type, mixed $id): string
    {
        if(empty($id)){
        return $this->prefix . ':' . $type;
        }

        return $this->prefix . ':' . $type . ':' . $id;
    }

    public function get(string $type ,string|null $id = null, callable $callback = null, int $ttl = 3600): array|null
    {
        $key = $this->gerateKey($type, $id);

        if(Cache::has($key)){
            return Cache::get($key);
        }

        if($callback){
            $data = $callback();
            $this->put($type, $id, $data, $ttl);

            return $data;
        }

        return null;
    }

    public function put(string $type,string $id, mixed $value, int $ttl = 3600)
    {
        $key = $this->gerateKey($type, $id);

        Cache::put($key, $value, $ttl);
    }

    public function forget(string $key, string $id)
    {
        $key = $this->gerateKey($key, $id);

        Cache::get($key, $id);
    }
}

# Laravel Elasticsearch



## 版本对应

| Elasticsearch Version | laravel-elasticsearch Branch |
| --------------------- | ------------------------ |
| >= 7.0                | 1.*                      |
## Install

You can install the package via composer:

```
composer require lingxiang/laravel-elasticsearch
```

## Laravel

服务区提供者，门面配置 ``config / app.php``

```
'providers' => [
    Lingxiang\Elasticsearch\LaravelServiceProvider::class
]

```

```
'aliases' => [
    'Elasticsearch' => Lingxiang\Elasticsearch\LaravelServiceFacade::class
]

```

创建config配置search.php
```
php artisan vendor:publish --provider="Lingxiang\Elasticsearch\LaravelServiceProvider"
```



## 简单上手

### Create

```php

$result = \Elasticsearch::index('index')->type('type')->create([
    'key' => 'value',
    'key2' => 'value2',
]);

```

### Update

```php
$result = \Elasticsearch::index('index')->type('type')->update('id',[
    'key' => 'value2',
]);
dump($result);

```

### Delete

```php

$result = \Elasticsearch::index('index')->type('type')->delete('id');
dump($result);

```

### Select

```php
//指定索引index和type
$builder = \Elasticsearch::index('laisiou_test')->type('user');

//全查询，但因ES聚合查询引擎的原因只能返回10条
$result = $builder->get();

//骚操作全查询
$result = $builder->take($builder->count())->get();

//根据id查询一条 注：查询不到则返回 null
$result = $builder->whereTerm('id',1)->first();

//子条件查询
$result = $builder->where(function ($inQuery) {
    $inQuery->whereTerm('key',1)->orWhereTerm('key',2)
})->whereTerm('key1',1)->get();
```

### 更多查询

skip / take
```php
$builder->take(10)->get(); // or limit(10)
$builder->offset(10)->take(10)->get(); // or skip(10)
```

term query
```php
$builder->whereTerm('key',value)->first();
```

match query
```php
$builder->whereMatch('key',value)->first();
```

range query
```php
$builder->whereBetween('key',[value1,value2])->first();
```

where in query
```php
$builder->whereIn('key',[value1,value2])->first();
```

logic query
```php
$builder->whereTerm('key',value)->orWhereTerm('key2',value)->first();
```

nested query
```php
$result = $builder->where(function (Builder $inQuery) {
    $inQuery->whereTerm('key',1)->orWhereTerm('key',2)
})->whereTerm('key1',1)->get();
```

### 所有可用条件方法

```php
public function select($columns): self
```

```php
public function where($column, $operator = null, $value = null, $leaf = 'term', $boolean = 'and'): self
```


```php
public function orWhere($field, $operator = null, $value = null, $leaf = 'term'): self
```

```php
public function whereMatch($field, $value, $boolean = 'and'): self
```

```php
public function orWhereMatch($field, $value, $boolean = 'and'): self
```

```php
public function whereTerm($field, $value, $boolean = 'and'): self
```

```php
public function whereIn($field, array $value)
```

```php
public function orWhereIn($field, array $value)
```

```php
public function orWhereTerm($field, $value, $boolean = 'or'): self
```

```php
public function whereRange($field, $operator = null, $value = null, $boolean = 'and'): self
```

```php
public function orWhereRange($field, $operator = null, $value = null): self
```

```php
public function whereBetween($field, array $values, $boolean = 'and'): self
```

```php
public function orWhereBetween($field, array $values): self
```

```php
public function orderBy(string $field, $sort): self
```

```php
public function scroll(string $scroll): self
```

```php
public function aggBy($field, $type): self
```

```php
public function select($columns): self
```

### 获取结果的方法
```php
public function get(): Collection
```

```php
public function paginate(int $page, int $perPage = 15): Collection
```

```php
public function first()
```

```php
public function byId($id)
```

```php
public function byIdOrFail($id): stdClass
```

```php
public function chunk(callable $callback, $limit = 2000, $scroll = '10m')
```

```php
public function create(array $data, $id = null, $key = 'id'): stdClass
```

```php
public function update($id, array $data): bool
```

```php
public function delete($id)
```

```php
public function count(): int
```

### 日志

```php
$builder->enableQueryLog();
```

### Elastisearch object

```php
\Elasticsearch::getElasticSearch() // 或者 \Elasticsearch::search()
```




## License
[MIT license](https://opensource.org/licenses/MIT)

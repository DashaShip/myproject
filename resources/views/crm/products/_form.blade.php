@include('forms._input', [
    'label'=>'Название продукта',
    'name'=>'name',
    'type'=>'string',
    'value'=>isset($user)?$user->getName() : '',
])

@include('forms._input', [
    'label'=>'Описание',
    'name'=>'description',
    'type'=>'string',
    'value'=>isset($user)?$user->getDescription() : '',
])

@include('forms._input', [
    'label'=>'Цена',
    'name'=>'price',
    'type'=>'integer',
    'value'=>isset($user)?$user->getPrice() : '',
])


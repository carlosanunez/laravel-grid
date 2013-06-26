#Laravel Grid DataProvider#

##Installation##

add in app.config

```php
return array(
    'providers'=>array(
        ...
        ...
        'Witooh\GridDataprovider\GridDataproviderServiceProvider',
    ),

    'alias'=>array(
        '''
        ...
        'JqGrid' => 'Witooh\GridDataprovider\Facades\JqGrid',
    ),
);
```

##Usage##

There are 2 classes have to use 
- Criteria
- JqGrid

Example

```php
public function dataProvider()
    {
        //Create new Criteria with table name
        $criteria = new Criteria('Post');

        //If title is not empty, it will generate sql where (AND) condition
        $criteria->compare('title', Input::get('title'));

        //If title is not empty, it will generate sql where (OR) condition
        $criteria->orCompare('title', Input::get('content'));

        //use Laravel Query Builder
        $criteria->query->leftJoin('comment', 'comment.post_id', '=', 'post.id');

        //make the JqGrid dataprovider
        //Dont care of the parameter which jqgrid send to the sever
        //This class will detected Input by itself.
        //Frist param is the criteria object
        //Second param is primary_key for jqgrid default is 'id'
        //return data array
        return JqGrid::make($criteria, 'post.id');
    }
```
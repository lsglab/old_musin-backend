# Backend



## Use API:
### Login

- ```/api/auth/login``` to login, returns a jwt token and a remember me token
- ```/api/auth/logout``` to logout
- ```/api/auth/user``` returns the currently logged in user

If no jwt key is sent in an Authroization header, the public account will be used

### Tables

General usage:

```/api/{tableName}?{parameters}```

Use 
- ```GET``` to retrieve all entries that match the query
- ```PUT``` to edit all found entries (e.g /api/users?id=2, user with the id 2 will be edited), usually no more than one entry at a time can be modified. Returns all edited entries.
- ```POST``` to create a new entry. The created entry will be returned. 
- ```DELETE``` to delete all entries that match the search query (e.g /api/users?id=2, user with the id 2 will be deleted)

returns the selected entries and all their relations

#### Special parameters:

- ```_no_relations```: if set to true the entries of the related tables will not be returned, e.g if a role belongs to a user the role will not be returned when the user entry is requested
- ```_search: query``` --> searches in all accessible columns for the given string
- ```_orderBy: asc | desc``` --> the entries will be ordered  

## Default tables

### Roles, Users and permissions


#### Users

Every user has a role, which in turn has permissions. The role the user has defines its permissions. 
#### Roles

- ```id: int```
- ```name: string``` --> name of the role
- ```description: string``` --> short description of what the role is used for

#### Permissions:

- ```action: string``` --> The action of the role (More on that later)
- ```role_id: int``` --> The role this permission belongs to
- ```table: string``` --> For which table this permission is for

#### Actions:

The action defines what the user is capable of. 
Possible actions:

- ```read```: The user is allowed to read all entries of a table
- ```read-self```: the user is allowed to real alle entries he created
- ```edit```: The user can edit all entries
- ```edit-self```: The user can edit all entries he created
- ```delete```: The user can delete all entries
- ```delete-self```: The user can delete all entries he created
- ```create```: The user can create entries

## Creating new tables

General syntax:

```
namespace App\Tables;
use App\Tables\Base\BaseTable;
use App\Tables\Columns\Boolean;

class ExampleTable extends BaseTable{
    public string $name = 'example';

    public array $children = [];

    public function __construct(){
        $this->columns = [
            new Boolean($this, 'varname', ['unique' => true]);
        ];
        $this->relations = [
            new BelongsTo($this, 'App\Tables\UserTable', 'user_id');
        ];
        parent::__construct();
    }
}
```

In the columns section, all columns (except columsn that express relations between tables) are defined using the column classes. 

The relations between tables are expressed by using the relation classes.

Every column takes an array as the last parameter. This array contains some config with which the behaviour of the column can be modified. 

The different attributes that can be used:
- ```unique```: The column value is unique
- ```required```: An entry cannot be created without this column
- ```identifier```: Several columns together can form an unique identifier
- ```hidden```: The column wont show up in the api response, and it cant be queried for
- ```userFillable```: If a column is userFillable it can be modified via mass assignment but not by the user via a request
- ```fillable```: If a column is not fillable it cannot be modified via mass assignment
- ```default```: The default value for a column
### Children

If a table has children, then every permission the user has is inherited by its children.

E.g The Role Table has the permission table as a child. This means that if the user is given edit permission on the role table he can also edit entries of the permission table. 

Children should be used whenever two tables should use the same permissions. E.g.: It doesnt makes sense to treat the Role and Permission Table seperatley when it comes to permissions.  

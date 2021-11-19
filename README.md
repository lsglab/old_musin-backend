# Backend



## How to use:
### Login

- /auth/login to login, returns a jwt token and a remember me token
- /auth/logout to logout
- /auth/user returns the currently logged in user

If no jwt key is sent in an Authroization header, the public account will be used

### Retrieve table entries

/{tableName}?{parameters}

returns the selected entries and all their relations

#### Special parameters:

- ```_no_relations```: if set to true the entries of the related tables will not be returned, e.g if a role belongs to a user the role will not be returned when the user entry is requested
- ```_search: query``` --> searches in all accessible columns for the given string
- ```_orderBy: asc | desc``` --> the entries will be ordered  

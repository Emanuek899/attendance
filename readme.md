# Documentation
## Api doc
In order to use the api there is some aspects to know if you want to work efficiently 
with

### How use it?

by the moment you can only use a testing version of the api that follows a specific on the payloads. 

#### Get Method
Payload format for a get method without basic conditions (only and) 
```json
{
    "file": "RolesRepository"
}
```

Payload format with support for basic conditions (only and) and columns, you can skip columns if you want all columns
```json
{
    "file": "RolesRepository",
    "cols": ["role_id"],
    "cond": {
        "role_id": ["=", 12]
    }
}
```
#### Post Method
If you want to use post method you must use this format. The new section of the json contains
the the columns of the table. No null values exist
in database son you must specify the values
```json
{
    "file": "RolesRepository",
    "new": {
        "role_id": 12,
        "permission_id": 15
    },kkkkk
}
```kpkp

#### Update method
it works silimar to post method, with some diferencies. Be aware on your input
```json
{
    "file": "RolesRepository",
    "new": {
        "role_id": 12
    },
    "cond": {
        "role_id": ["=", 12]
    }
}
```

#### Delete Method
For last the delete method works in only this way
```json
{
    "file": "RolesRepository",
    "cond": {
        "role_id": ["=", 12]
    }
}
```
You can't delete without conditions, this will return an advertise about it. This to prevent accidentally deletes
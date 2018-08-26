<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title binding-property="title" />
</head>
<body>
    <form method="post" action="/index/cosimo">
        <h1 binding-property="textoftable" />
        <div>
            <placeholder binding-property="error" />
            <input type="text" name="name" binding-property="name" />
            <input type="text" name="bho2" binding-property="surname" />
            <input type="submit" value="" binding-property="submittext" />
            <placeholder binding-property="table" />
            <placeholder binding-property="validator" />
        </div>
    </form>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title binding-property="title" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <form method="post" action="/index/cosimo">
        <placeholder binding-property="response" />
        <h1 binding-property="textoftable" />
        <div>
            <placeholder binding-property="error" />
            <input type="text" name="name" binding-property="name" />
            <input type="text" name="bho2" binding-property="surname" />
            <input type="submit" value="" binding-property="submittext" />
            <placeholder binding-property="table" />
            <placeholder binding-property="validator" />
        </div>
        <table-configuration name="tableHelper">
            <column id="Id" binding-property="Id" />
            <column id="Nome_device" binding-property="Nome_device" style="color: yellow" />
            <column id="Nome_cell" binding-property="Nome_cell" style="color: yellow" />
        </table-configuration>
    </form>
</body>
</html>
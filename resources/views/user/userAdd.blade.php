@extends('layouts.head')
@section('head')
<body>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">&nbsp;</div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Form Elements
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form id="form" action="" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>姓名</label>
                                        <input class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label>邮箱</label>
                                        <input class="form-control" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label>初始密码</label>
                                        <input class="form-control" name="password" value="123456">
                                    </div>
                                    <div class="form-group">
                                        <label>所属用户组</label>
                                        <select class="form-control" name="roleid">
                                            @foreach($userRoleList as $rows)
                                            <option value="{{$rows['roleid']}}">{{$rows['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-default" onclick="fromSubmit()">确定</button>
                                    <button type="button" class="btn btn-default" onclick="fromQuit()">退出</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
</body>
<script>
var frameindex= parent.layer.getFrameIndex(window.name);
function fromSubmit(){
    var data = $('#form').serialize();
    var url = "";
    $.post(url,data,function(data){
        if(data.status=='success'){
            layer.msg(data.msg, {time:1000}, function(){
                parent.location.href="/user";
            });
        }else{

        }
    },'json');
}
function fromQuit(){
    parent.layer.close(frameindex);
}
</script>
@endsection

@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">用户组列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow:hidden;line-height: 34px;">
                    DataTables Advanced Tables
                    @if(isset($buttonList[6]))<button class="btn btn-primary" type="button" style="float:right;" onclick="window.location='{{$buttonList[6]['route']}}'">{{$buttonList[6]['name']}}</button>@endif
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-admin">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>权限</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($userRoleList as $rows)
                        <tr>
                            <td>{{$rows['name']}}</td>
                            <td>{{$rows['rule']}}</td>
                            <td>@if($rows['disabled']) 禁用 @else 可用 @endif</td>
                            <td class="center">
                                @if(isset($buttonList[10]) && $rows['roleid'] != 1)<button class="btn btn-outline btn-warning" type="button" onclick="window.location='{{$buttonList[10]['route']}}'">修改</button>@endif&nbsp;&nbsp;
                                @if(isset($buttonList[11]) && $rows['roleid'] != 1)<button class="btn btn-outline btn-danger" type="button" onclick="if(confirm('确定要删除吗?'))window.location='{{$buttonList[11]['route']}}'">删除</button>@endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-admin').DataTable({
            responsive: true
        });
    });
</script>
@endsection

@if( in_array('edit',$module_actions ) )
<a class="btn btn-sm btn-icon btn-info" href="{{ route($module_name.'.edit', $item->id) }}"><i class="fa fa-pencil-alt"></i></a>
@endif
@if( in_array('delete',$module_actions ) )
<button class="btn btn-sm btn-icon btn-danger" data-toggle="modal" data-target="#delete-item-modal" onclick="showDeleteItemModal(this,event,'{{$item->title}}')" data-href="{{ route($module_name.'.destroy', $item->id) }}"><i class="fa fa-trash"></i></button>

@endif
@if( in_array('show',$module_actions ) )
<a class="btn btn-sm btn-icon  btn-warning" href="{{ route($module_name.'.show',$item->id) }}"><i class="fa fa-eye"></i></a>
@endif
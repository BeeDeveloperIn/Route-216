@extends($themeLayoutPath)
@section('menu_title')
Stores
@endsection
@section('content')
<div class="container">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">{{ __('store.title_store_list') }}</h3>
                <div class="card-toolbar text-right">
                    <div class="example-tools justify-content-center">
                        <a href="{{ route('admin.addStore') }}" class="btn btn-secondary">{{ __('store.title_add_store') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
           <div class="row">
               <div class="col-md-12 form-group">
                   @if ($stores->count())
                   <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('store.term') }} Name</th>
                            <th scope="col">Country</th>
                            <th scope="col">State</th>
                            <th scope="col">Pincode</th>
                            <th scope="col">Address line 1</th>
                            <th scope="col">Address line 2</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $index => $store)
                        <tr>
                            <th>
                                {{ (($stores->currentPage()-1) * $stores->count()) + $index + 1 }}.
                            </th>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->country }}</td>
                            <td>{{ $store->state }}</td>
                            <td>{{ $store->pincode }}</td>
                            <td>{{ $store->address_line_1 }}</td>
                            <td>{{ $store->address_line_2 }}</td>
                            <td>
                                <a href="#" type="button" class="btn btn-primary mr-2">Edit</a>
                                <a href="#" type="button" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               </div>
               <div class="col-md-12 mk-custom-pagination">
                {{ $stores->links() }}
               </div>
               @else
                <h4>{{ __('store.store_list_empty') }}</h4>
                   @endif
           </div>
    </div>

</div>
</div>
@endsection

@extends('admin::layouts.master')

@section('head-tag')
    <title> کتاب  ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
           <li class="breadcrumb-item font-size-12 active" aria-current="page"> کتاب  ها </li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        کتاب  ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.book.create') }}" class="btn btn-info btn-sm">ایجاد کتاب جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                           <th>توضیحات</th>
                            <th>وضعیت</th>
                            <th>عکس</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($books as $book)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $book->title }}</td>
                           <td>{{ $book->description }}</td>
                                <td class="text-{{ $book->status == 1 ? 'success' : 'danger' }}">{{ $book->status == 1 ? 'فعال' : 'غیر فعال' }}</td>
                                <td>
                                    <img src="{{ asset($book->image) }}" width="80px">
                                </td>
                            <td class="width-22-rem text-left">
                                 <a href="{{ route('admin.book.status' , $book->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-{{ $book->status == 0 ? 'check text-success' : 'window-close text-danger'  }}"></i></a>
                                <a href="{{ route('admin.book.edit' , $book->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> </a>
                                <form class="d-inline" action="{{ route('admin.book.destroy' , $book->id) }}" method="post">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash-alt"></i> </button>
                                </form>
                            </td>
                            </tr>
                            @empty
<p> کتابی وجود ندارد</p>
                        @endforelse

                        </tbody>
                    </table>
                </section>
                {{ $books->links() }}
            </section>
        </section>
    </section>

@endsection


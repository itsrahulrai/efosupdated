 @extends('backend.layout.layouts')
 @section('title', 'Add Blog Categories - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
 @section('content')

     <main class="app-wrapper">
         <div class="container">
             <div class="app-page-head d-flex align-items-center justify-content-between">
                 <div class="clearfix">
                     <h1 class="app-page-title"> Add Blog Categories</h1>
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb mb-0">
                             <li class="breadcrumb-item">
                                 <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                             </li>
                             <li class="breadcrumb-item active" aria-current="page">Add Blog Categories</li>
                         </ol>
                     </nav>
                 </div>
             </div>

             <div class="row">
                 <div class="col-12">
                     <div class="card">
                         <div class="card-header">
                             <h6 class="card-title">Add Blog Categories</h6>
                         </div>
                         <div class="card-body">
                             @if ($errors->any())
                                 <div class="alert alert-danger">
                                     <ul class="mb-0">
                                         @foreach ($errors->all() as $err)
                                             <li>{{ $err }}</li>
                                         @endforeach
                                     </ul>
                                 </div>
                             @endif

                             @php $isEdit = isset($category); @endphp

                           <form class="row" method="POST"
                                action="{{ $isEdit ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                <!-- Category Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text"
                                        id="category_name"
                                        name="name"
                                        class="form-control"
                                        placeholder="Enter Category Name"
                                        value="{{ old('name', $category->name ?? '') }}"
                                        required>
                                </div>

                                <!-- Slug -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text"
                                        id="category_slug"
                                        name="slug"
                                        class="form-control"
                                        placeholder="auto-generated"
                                        value="{{ old('slug', $category->slug ?? '') }}">
                                    <small class="text-muted">Leave empty to auto-generate from name.</small>
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $isEdit ? 'Update Category' : 'Save Category' }}
                                    </button>
                                </div>
                            </form>

                         </div>

                     </div>
                 </div>
             </div>
         </div>
     </main>

 @endsection

 @push('script')
     <script>
    const nameInput = document.getElementById('category_name');
    const slugInput = document.getElementById('category_slug');

    nameInput.addEventListener('input', function () {
        // Only auto-generate if slug is empty
        if (slugInput.value.trim() === '') {
            slugInput.value = generateSlug(this.value);
        }
    });

    function generateSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/&/g, 'and')          // Replace &
            .replace(/[^a-z0-9]+/g, '-')  // Replace non-alphanumeric with -
            .replace(/-+/g, '-')          // Remove multiple -
            .replace(/^-|-$/g, '');       // Trim - from start/end
    }
</script>

 @endpush

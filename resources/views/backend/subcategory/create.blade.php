 @extends('backend.layout.layouts')
 @section('title', 'Sub Categories - Career Guidance Services | EFOS Edumarketers Pvt Ltd')
 @section('content')

 <main class="app-wrapper">
     <div class="container">
         <div class="app-page-head d-flex align-items-center justify-content-between">
             <div class="clearfix">
                 <h1 class="app-page-title"> Sub Categories</h1>
                 <nav aria-label="breadcrumb">
                     <ol class="breadcrumb mb-0">
                         <li class="breadcrumb-item">
                             <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                         </li>
                         <li class="breadcrumb-item active" aria-current="page">Sub Categories</li>
                     </ol>
                 </nav>
             </div>
         </div>

         <div class="row">
             <div class="col-12">
                 <div class="card">
                     <div class="card-header">
                         <h6 class="card-title">Sub Categories</h6>
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

                         @php $isEdit = isset($subcategory); @endphp

                         <form class="row" method="POST"
                             action="{{ $isEdit
                                        ? route('admin.sub-categories.update', $subcategory->id)
                                        : route('admin.sub-categories.store') }}">
                             @csrf
                             @if ($isEdit)
                             @method('PUT')
                             @endif

                             <!-- Parent Category -->
                             <div class="col-md-6 mb-3">
                                 <label class="form-label">Category</label>
                                 <select name="category_id" class="form-select" required>
                                     <option value="">-- Select Category --</option>
                                     @foreach ($categories as $cat)
                                     <option value="{{ $cat->id }}"
                                         {{ old('category_id', $subcategory->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                         {{ $cat->name }}
                                     </option>
                                     @endforeach
                                 </select>
                             </div>

                             <!-- Sub Category Name -->
                             <div class="col-md-6 mb-3">
                                 <label class="form-label">Sub Category Name</label>
                                 <input type="text"
                                     id="category_name"
                                     name="name"
                                     class="form-control"
                                     placeholder="Enter Sub Category Name"
                                     value="{{ old('name', $subcategory->name ?? '') }}"
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
                                     value="{{ old('slug', $subcategory->slug ?? '') }}">
                                 <small class="text-muted">Leave empty to auto-generate</small>
                             </div>

                             <!-- Submit -->
                             <div class="col-12 mt-3">
                                 <button type="submit" class="btn btn-primary">
                                     {{ $isEdit ? 'Update' : 'Submit' }}
                                 </button>
                                 <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-secondary">
                                     Cancel
                                 </a>
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

     let slugManuallyEdited = false;

     // Detect manual slug edit
     slugInput.addEventListener('input', function() {
         slugManuallyEdited = true;
     });

     nameInput.addEventListener('input', function() {
         const nameValue = this.value.trim();

         // If name is empty → clear slug
         if (nameValue === '') {
             slugInput.value = '';
             slugManuallyEdited = false;
             return;
         }

         // Auto-generate slug ONLY if user did not edit slug manually
         if (!slugManuallyEdited) {
             slugInput.value = generateSlug(nameValue);
         }
     });

     function generateSlug(text) {
         return text
             .toLowerCase()
             .trim()
             .replace(/&/g, 'and')
             .replace(/[^a-z0-9]+/g, '-')
             .replace(/-+/g, '-')
             .replace(/^-|-$/g, '');
     }
 </script>
 @endpush

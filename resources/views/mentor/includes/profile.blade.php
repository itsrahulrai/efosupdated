 <div class="slot-card">

     <h6 class="mb-3">Basic Information</h6>


     <div class="card-light">
         <!-- PROFILE FORM -->
         <div class="slot-card">
             <h6 class="mb-3">
                 Basic Information
             </h6>
             <form action="{{ route('mentorprofile.update') }}" method="POST" enctype="multipart/form-data">
                 @csrf

                 <div class="row g-3">

                     <div class="col-md-6">
                         <label class="form-label small">Expertise</label>
                         <select name="mentor_category_id" class="form-select form-select-sm">
                             <option value="">Select Expertise</option>

                             @foreach ($expertises as $expertise)
                                 <option value="{{ $expertise->id }}"
                                     {{ old('mentor_category_id', $mentor->mentor_category_id ?? '') == $expertise->id ? 'selected' : '' }}>
                                     {{ $expertise->name }}
                                 </option>
                             @endforeach

                         </select>
                     </div>

                     <div class="col-md-6">
                         <label class="form-label small">Name</label>
                         <input type="text" name="name" value="{{ old('name', $mentor->name ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-6">
                         <label class="form-label small">Email</label>
                         <input type="email" name="email" value="{{ old('email', $mentor->email ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-6">
                         <label class="form-label small">Phone</label>
                         <input type="text" name="phone" value="{{ old('phone', $mentor->phone ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-4">
                         <label class="form-label small">State</label>
                         <input type="text" name="state" value="{{ old('state', $mentor->state ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-4">
                         <label class="form-label small">City</label>
                         <input type="text" name="city" value="{{ old('city', $mentor->city ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-4">
                         <label class="form-label small">Zip Code</label>
                         <input type="text" name="zip_code" value="{{ old('zip_code', $mentor->zip_code ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-12">
                         <label class="form-label small">Address</label>
                         <input type="text" name="address" value="{{ old('address', $mentor->address ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-6">
                         <label class="form-label small">Experience</label>
                         <input type="text" name="experience"
                             value="{{ old('experience', $mentor->experience ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-6">
                         <label class="form-label small">Skills</label>
                         <input type="text" name="skills" value="{{ old('skills', $mentor->skills ?? '') }}"
                             class="form-control form-control-sm">
                     </div>

                     <div class="col-md-12">
                         <label class="form-label small">Bio</label>
                         <textarea name="bio" rows="3" class="form-control form-control-sm">{{ old('bio', $mentor->bio ?? '') }}</textarea>
                     </div>

                     <div class="col-md-6">

                         <label class="form-label small">Profile Photo</label>

                         <input type="file" name="profile_photo" class="form-control form-control-sm">

                         @if (isset($mentor->profile_photo))
                             <img src="{{ static_asset($mentor->profile_photo) }}" width="60" class="rounded mt-2">
                         @endif

                     </div>

                 </div>

                 <div class="text-end mt-3">

                     <button type="submit" class="btn btn-success btn-sm">

                         Save Profile

                     </button>

                 </div>

             </form>
         </div>

     </div>
 </div>

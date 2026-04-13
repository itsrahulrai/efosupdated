    <?php

    use App\Http\Controllers\Admin\AdminStudentController;
    use App\Http\Controllers\Admin\BecomePartnerController;
    use App\Http\Controllers\Admin\BlogsController;
    use App\Http\Controllers\Admin\CategoryController;
    use App\Http\Controllers\Admin\CompanyController;
    use App\Http\Controllers\Admin\CourseController;
    use App\Http\Controllers\Admin\DashboardController;
    use App\Http\Controllers\Admin\JobAppliedController;
    use App\Http\Controllers\Admin\JobCategoryController;
    use App\Http\Controllers\Admin\JobController;
    use App\Http\Controllers\Admin\JobSubCategoryController;
    use App\Http\Controllers\Admin\PageController;
    use App\Http\Controllers\Admin\SubCategoryController;
    use App\Http\Controllers\Admin\YoutubeVideoController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Franchie\FranchiseController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\JobApplicationController;
    use App\Http\Controllers\LMS\AssignedCourseController;
    use App\Http\Controllers\LMS\BundleCourseController;
    use App\Http\Controllers\LMS\CertificateController;
    use App\Http\Controllers\LMS\CourseBuyController;
    use App\Http\Controllers\LMS\CourseChapterController;
    use App\Http\Controllers\LMS\CourseLessonController;
    use App\Http\Controllers\LMS\CourseOrderController;
    use App\Http\Controllers\LMS\LearningCourseController;
    use App\Http\Controllers\LMS\QuizController;
    use App\Http\Controllers\LMS\QuizQuestionController;
    use App\Http\Controllers\LMS\StudentLessonController;
    use App\Http\Controllers\LMS\SubjectController;
    use App\Http\Controllers\MentorController;
    use App\Http\Controllers\MentorDashboard;
    use App\Http\Controllers\Mentor\MentorAvailabilityController;
    use App\Http\Controllers\Mentor\MentorCategoryController;
    use App\Http\Controllers\Mentor\MentorProfileController;
    use App\Http\Controllers\Mentor\MentorSessionPriceController;
    use App\Http\Controllers\Mentor\SessionBookingController;
    use App\Http\Controllers\NewsEventController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\MentorPaymentController;
    use App\Http\Controllers\Auth\GoogleController;
    use Illuminate\Support\Facades\Route;


    Route::get('/', [HomeController::class, 'index'])->name('home');


    Route::get('/clear-cache', function () {
        Artisan::call('optimize:clear');
        return "cache cleared";

    });


    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');

    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


    Route::get('news-events', [HomeController::class, 'newsEvents'])->name('news-events');

    Route::get(
        'opportunity-highlights/{category:slug?}',
        [HomeController::class, 'opportunityHighlights']
    )->name('opportunity-highlights');

    Route::get('/search-partner-centers', [HomeController::class, 'search'])
        ->name('partner.centers.search');

    // Route::get(
    //     'opportunity-highlights/{category:slug?}',
    //     [HomeController::class, 'opportunityHighlights']
    // )->name('opportunity-highlights');

    Route::get(
        'jobs/subcategories/{category}',
        [HomeController::class, 'getSubCategories']
    )->name('jobs.subcategories');

    Route::get('/opportunity/{job:slug}', [HomeController::class, 'showJobs'])->name('jobs.show');

    Route::get('mission-vision', function ()
    {
        return view('frontend.mission-vision');
    })->name('mission-vision');

    Route::get('founders', function ()
    {
        return view('frontend.founders');
    })->name('founders');

    Route::get('stake-holders', function ()
    {
        return view('frontend.stake-holders');
    })->name('stake-holders');

    Route::get('contact-us', function ()
    {
        return view('frontend.contact-us');
    })->name('contact-us');

    Route::get('student-registration', function ()
    {
        return view('frontend.registration');
    })->name('student-registration');

    Route::get('franchise-registration', function ()
    {
        return view('frontend.franchise-registration');
    })->name('franchise-registration');

    Route::get('career-updates', [HomeController::class, 'careerUpdates'])->name('career-updates');
    Route::get('career-updates-details/{slug}', [HomeController::class, 'careerUpdatesDetails'])->name('career-updates.details');

    Route::get('skill-courses', [HomeController::class, 'skillCourses'])->name('skill-courses');

    Route::get('bundle-courses', [HomeController::class, 'BundleCourses'])->name('bundle-courses');

    Route::get('/course/{slug}', [HomeController::class, 'coursesDetails'])->name('course.details');

    // video / lesson
    Route::get('/course/lesson/{slug}', [HomeController::class, 'lesson'])->name('course.lesson');

    // quiz
    Route::get('/course/quiz/{id}', [HomeController::class, 'quiz'])->name('course.quiz');

    Route::get('find-center', [HomeController::class, 'findCenter'])->name('find.center');

    Route::get('become-a-mentor', [MentorController::class, 'becomeAMentor'])->name('become-a-mentor');
    Route::get('mentorship', [MentorController::class, 'mentorship'])->name('mentorship');

    Route::post('/become-mentor', [MentorController::class, 'storeMentor'])->name('mentor.store');
    Route::get('/mentorship-details/{slug}', [MentorController::class, 'mentorshipDetails'])->name('mentorship-details');

    // Studnet Route

    // Route::get('/student/login', function ()
    // {
    //     return view('student.login');
    // })->name('student.login');

    Route::get('/student/login', function (Illuminate\Http\Request $request)
    {

        if ($request->apply_job)
        {
            session(['apply_job' => $request->apply_job]);
        }

        return view('student.login');

    })->name('student.login');




    Route::get('/student/forgot-password', function ()
    {
        return view('student.forgot-password');
    })->name('student.forgot-password');

    Route::resource('login', LoginController::class)->only(['index', 'store', 'create', 'destroy']);

    // Backend Route

    Route::get('admin/dashboard', function ()
    {
        return view('backend.index');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Route::get('admin/add-company', function () {
    //     return view('backend.company.add-company');
    // })->name('add-company');

    // Route::get('admin/company-list', function () {
    //     return view('backend.company.company-list');
    // })->name('company-list');

    Route::middleware('auth')->group(function ()
    {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::prefix('admin')->name('admin.')->group(function ()
        {

            Route::post('categories/status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

            Route::resource('categories', CategoryController::class);
            Route::resource('blogs', BlogsController::class);

            Route::resource('companies', CompanyController::class);
            Route::delete('news-events/image/{id}', [NewsEventController::class, 'deleteImage'])->name('news-events.image.delete');

            Route::resource('news-events', NewsEventController::class);
        });

        Route::get('admin/calendar', function ()
        {
            return view('backend.calendar');
        })->name('calendar');
    });

    Route::post('/franchise-apply', [HomeController::class, 'applyFranchise'])
        ->name('franchises.store');

    Route::post('/contact-store', [HomeController::class, 'sendContact'])->name('contact.store');

    Route::get('/thank-you', function ()
    {
        return view('frontend.thank-you');
    })->name('thank.you');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:admin'])->group(function ()
    {

        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('admin')->name('admin.')->group(function ()
        {
            Route::put('become-partner/{id}/update-status', [BecomePartnerController::class, 'updateStatus'])->name('become-partner.update-status');
            Route::resource('become-partner', BecomePartnerController::class);

            Route::post('subcategories/status', [SubCategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');

            Route::resource('sub-categories', SubCategoryController::class);
            Route::post('jobs/status', [JobController::class, 'toggleStatus'])->name('jobs.toggle-status');

            Route::get('jobs/get-subcategories/{category}', [JobController::class, 'getSubCategories'])->name('jobs.get-subcategories');

            Route::post('job-categories/status', [JobCategoryController::class, 'toggleStatus'])->name('job-categories.toggle-status');
            Route::resource('job-categories', JobCategoryController::class);

            Route::post('job-sub-categories/status', [JobSubCategoryController::class, 'toggleStatus'])->name('job-sub-categories.toggle-status');

            Route::resource('job-sub-categories', JobSubCategoryController::class);

            Route::resource('jobs', JobController::class);

            Route::get('all/students', [AdminStudentController::class, 'index'])->name('all.students');
            Route::get('student/create', [AdminStudentController::class, 'create'])->name('create.student');
            Route::get('students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
            Route::put('students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
            Route::delete('students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
            // Store new student

            Route::post('students', [AdminStudentController::class, 'store'])
                ->name('students.store');

            Route::get('/students/{student}/documents', [AdminStudentController::class, 'documents'])->name('students.documents');
            Route::post('/students/{student}/documents/upload', [AdminStudentController::class, 'uploadDocuments'])->name('students.documents.upload');
            Route::delete('/documents/{document}', [AdminStudentController::class, 'deleteDocument'])->name('students.documents.delete');

            Route::post('/students/{student}/profile-status', [AdminStudentController::class, 'updateProfileStatus'])->name('students.profileStatus');

            Route::post('/students/{student}/assign-franchise', [AdminStudentController::class, 'storeAssignedFranchise'])->name('students.assign.store');

            Route::get('student-bulk-assign-template', [AdminStudentController::class, 'downloadStudentBulkAssignTemplate'])->name('bulkassign.students.template');
            Route::post('bulk-students/import', [AdminStudentController::class, 'import'])->name('bulk.students.import');

            Route::resource('courses', CourseController::class);

            Route::post('page/status', [PageController::class, 'toggleStatus'])->name('page.toggle-status');
            Route::resource('pages', PageController::class);

            Route::post('youtube/toggle-status', [YoutubeVideoController::class, 'toggleStatus'])->name('youtube.toggle-status');
            Route::resource('youtube', YoutubeVideoController::class)->names('youtube');

            Route::get('/applied-jobs', [JobAppliedController::class, 'index'])->name('applied.jobs');

            Route::post('/job-applications/update-status', [JobAppliedController::class, 'updateStatus'])->name('job-applications.update-status');
            Route::delete('/job-applications/{jobApplication}', [JobAppliedController::class, 'destroy'])->name('job-applications.destroy');

            // LMS
            Route::post('subjects/toggle-status', [SubjectController::class, 'toggleStatus'])->name('subject.toggle-status');
            Route::resource('subject', SubjectController::class);

            Route::post('learning-course/status', [LearningCourseController::class, 'updateStatus'])->name('learning-course.status');
            Route::resource('learning-course', LearningCourseController::class);

            Route::post('bundle-course/status', [BundleCourseController::class, 'updateStatus'])->name('bundle-course.status');
            Route::resource('bundle-course', BundleCourseController::class);

            Route::get('bulk-assign-template', [AssignedCourseController::class, 'downloadBulkAssignTemplate'])->name('assigned-course.template');
            Route::post('assigned-course/import', [AssignedCourseController::class, 'import'])->name('assigned-course.import');

            Route::resource('assigned-course', AssignedCourseController::class);

            Route::post('course-chapter/status', [CourseChapterController::class, 'updateStatus'])->name('course-chapter.status');
            Route::resource('course-chapter', CourseChapterController::class);

            Route::get('course/{course}/chapters', [CourseLessonController::class, 'getByCourse'])->name('course.chapters');

            Route::post('lesson/status', [CourseLessonController::class, 'updateStatus'])->name('lesson.status');
            Route::resource('lesson', CourseLessonController::class);

            Route::post('quiz/status', [QuizController::class, 'updateStatus'])->name('quiz.status');
            Route::get('courses/{course}/chapters', [QuizController::class, 'getChapters'])->name('courses.chapters');

            Route::get('quiz-results/{id}/modal', [QuizController::class, 'showModal'])->name('quiz.result.modal');
            Route::resource('quiz', QuizController::class);

            // Download sample excel
            Route::get('quiz-question-template', [QuizQuestionController::class, 'downloadTemplate'])->name('quiz-question.template');

            // Upload excel
            Route::post('quiz-question-import', [QuizQuestionController::class, 'importQuestions'])->name('quiz-question.import');

            Route::resource('quiz-question', QuizQuestionController::class);

            Route::post('certificates', [CertificateController::class, 'store'])->name('certificates.store');
            Route::put('certificates/{id}', [CertificateController::class, 'update'])->name('certificates.update');
            Route::delete('certificates/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');

            Route::get('certificates/{id}/print', [CertificateController::class, 'print'])->name('certificates.print');

            Route::get('course/orders', [CourseOrderController::class, 'courseOrder'])->name('course.orders');

            Route::delete('course-orders/{id}', [CourseOrderController::class, 'destroyOrder'])->name('course-orders.destroy');

            // Mentor Platform
            Route::post('mentor-categories/status', [MentorCategoryController::class, 'updateStatus'])->name('mentor-categories.status');
            Route::resource('mentor-categories', MentorCategoryController::class);
            Route::post('mentor-profile/status', [MentorProfileController::class, 'updateStatus'])->name('mentor-profile.status');
            Route::resource('mentor-profile', MentorProfileController::class);

            Route::post('mentor-session-price/status', [MentorSessionPriceController::class, 'updateStatus'])->name('mentor-session-price.status');
            Route::resource('mentor-session-price', MentorSessionPriceController::class)->only(['store', 'update', 'destroy']);
            Route::post('mentor-availability/status', [MentorAvailabilityController::class, 'updateStatus'])->name('mentor-availability.status');
            Route::resource('mentor-availability', MentorAvailabilityController::class)->only(['store', 'update', 'destroy']);

            // Session Bookings
            Route::get('session/bookings', [SessionBookingController::class, 'sessionBookings'])->name('mentor-session.bookings');
            Route::post('/session-booking/status',[SessionBookingController::class, 'updateStatus'])->name('session-booking.status');

            Route::post('/session-booking/update-meeting',[SessionBookingController::class, 'updateMeeting'])->name('session-booking.updateMeeting');


            


        });
    });

    /*
    |--------------------------------------------------------------------------
    | FRANCHISE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:franchise'])->group(function ()
    {
        Route::get('/franchise/dashboard', fn() => view('franchise.dashboard'))
            ->name('franchise.dashboard');

        Route::get('/franchise/students', [FranchiseController::class, 'franchiseStudents'])->name('students.franchise');
        Route::resource('franchise', FranchiseController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Mentor ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:mentor'])->group(function ()
    {
        Route::get('/mentor/dashboard', [MentorDashboard::class, 'index'])->name('mentor.dashboard');
        Route::post('/mentor/profile/update', [MentorDashboard::class, 'MentorProfileupdate'])->name('mentorprofile.update');
        Route::post('/mentor/password/update', [MentorDashboard::class, 'MentorupdatePassword'])->name('mentor.password.update');
        Route::get('/mentor/messages', [MentorDashboard::class, 'messages'])->name('mentor.messages');

        Route::post('/mentor/price/store', [MentorDashboard::class, 'storePrice'])->name('mentorprice.store');
        Route::post('/mentor/price/update/{id}', [MentorDashboard::class, 'updatePrice'])->name('mentorprice.update');
        Route::get('/mentor/price/delete/{id}', [MentorDashboard::class, 'deletePrice'])->name('mentorprice.delete');

        Route::post('/mentor/slot/store',[MentorDashboard::class, 'storeSlot'])->name('mentorslot.store');
        Route::post('/mentor/slot/update/{id}',[MentorDashboard::class, 'updateSlot'])->name('mentorslot.update');
        Route::get('/mentor/slot/delete/{id}',[MentorDashboard::class, 'deleteSlot'])->name('mentorslot.delete');

        Route::post('mentor/update-booking-status',[MentorDashboard::class, 'updateBookingStatus'])->name('update.booking.status');

        
        Route::get('mentor/booking/{id}',[MentorDashboard::class, 'getBooking'])->name('fetched.booking');

        Route::post('mentor/update-meeting',[MentorDashboard::class, 'updateBookingMeeting'])->name('update.booking.meeting');


    });

    /*
    |--------------------------------------------------------------------------
    | STUDENT ROUTES
    |--------------------------------------------------------------------------
    */

    /* =====================
    PUBLIC STUDENT ROUTES
    ===================== */
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');

    Route::get('/courses/{slug}', [HomeController::class, 'courseDetails'])
        ->name('courses.details');

    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'apply'])->name('jobs.apply');

    /* =====================
    PROTECTED STUDENT ROUTES
    ===================== */


    /* store previous url before login */

    Route::get('/set-intended-url', function ()
    {
        session(['url.intended' => url()->previous()]);
        return response()->json(true);

    });


    Route::middleware(['auth', 'role:student'])->group(function ()
    {
        Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::get('/student/profile/download', [StudentController::class, 'downloadProfile'])->name('student.profile.download');
        Route::post('/student/change-password', [StudentController::class, 'changePassword'])->name('student.password.update');
        Route::post('/student/documents/upload',[StudentController::class, 'uploadDocuments'])->name('student.documents.upload');

        Route::get('/course/{course}/enroll-free', [CourseBuyController::class, 'enrollFree'])->name('course.enroll.free');
        Route::get('/bundle/enroll-free/{bundle}', [CourseBuyController::class, 'enrollBundleFree'])->name('bundle.enroll.free');

        // Paid course checkout
        Route::get('/course/{course}/checkout', [CourseBuyController::class, 'checkout'])->name('course.checkout');

        Route::get('/bundle/checkout/{bundle}', [CourseBuyController::class, 'bundleCheckout'])
            ->name('bundle.course.checkout');
    
        Route::post('/payment/initiate/{course}', [CourseBuyController::class, 'initiatePayment'])->name('payment.initiate');

        Route::post('/bundle/payment/initiate/{bundle}', [CourseBuyController::class, 'initiateBundlePayment'])
            ->name('bundle.payment.initiate');

        Route::get('/bundle/payment/success', [CourseBuyController::class, 'bundlePaymentSuccess'])
            ->name('bundle.payment.success');

        Route::get('/bundle/payment/failure', [CourseBuyController::class, 'bundlePaymentFailure'])
            ->name('bundle.payment.failure');

        Route::get('/bundle/thankyou/{courseBuy}', [CourseBuyController::class, 'bundleThankYou'])
            ->name('bundle.thankyou');

        Route::post('/quiz/{quiz}/submit', [StudentController::class, 'quizStore'])->name('quiz.submit');
        Route::get('certificates/{id}/print', [StudentController::class, 'print'])->name('certificate.print');
        Route::post('lesson/complete/{lesson}', [StudentLessonController::class, 'markComplete'])->name('lesson.complete');

        Route::post('/book-session', [MentorController::class, 'bookSession'])->name('book.session');

    });

    Route::get('/mentor/payment/initiate', [MentorPaymentController::class, 'initiatePayment'])
        ->name('mentor.payment.initiate');


    Route::get('/mentor/payment/success', [MentorPaymentController::class, 'paymentSuccess'])
        ->name('mentor.payment.success');

    Route::get('/mentor/payment/failure', [MentorPaymentController::class, 'paymentFailure'])
        ->name('mentor.payment.failure');





    Route::get('{slug}', [PageController::class, 'show'])
        ->name('pages.show');

    Route::get('/payment/success',
        [CourseBuyController::class, 'paymentSuccess']
    )->name('payment.success');

    Route::match(['get', 'post'], '/payment/failure',
        [CourseBuyController::class, 'paymentFailure']
    )->name('payment.failure');

    Route::get('course/{courseBuy}/thank-you', [CourseBuyController::class, 'thankYou'])
        ->name('course.thankyou');

    Route::middleware(['auth', 'role:admin'])
        ->post('/admin/clear-cache', function ()
    {

            Artisan::call('optimize:clear');

            return back()->with('success', 'Cache cleared successfully.');
        })
        ->name('admin.clear.cache');

    require __DIR__ . '/auth.php';

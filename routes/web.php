<?php

use App\Http\Controllers\AddcaseController;
use App\Http\Controllers\AddclientController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CaseBillController;
use App\Http\Controllers\CaseExportController;
use App\Http\Controllers\ClientBranchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\CourtTypeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\ImagegalleryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LegalNoticeCategoryController;
use App\Http\Controllers\LegalNoticeController;
use App\Http\Controllers\LegalNoticePricingController;
use App\Http\Controllers\ManagerAddclientRequestController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StafflistController;
use App\Http\Controllers\TrustedclientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// frontend route
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/contactus', [FrontendController::class, 'contactus'])->name('contactus');
Route::get('/aboutus', [FrontendController::class, 'aboutus'])->name('aboutus');
Route::get('/practice', [FrontendController::class, 'practice'])->name('practice');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/teams', [FrontendController::class, 'teams'])->name('teams');
Route::get('/showblog/{id}', [FrontendController::class, 'showblog'])->name('showblog');
Route::post('/subscribe-store', [FrontendController::class, 'subscriberStore'])->name('subscriber.store');
Route::post('/contact', [ContactController::class, 'contact'])->name('contact.store');


// Public Career/Job Routes (Frontend)
Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
Route::get('/careers/{job}', [CareerController::class, 'show'])->name('careers.show');
Route::post('/careers/{job}/apply', [CareerController::class, 'apply'])->name('careers.apply');
Route::get('/careers/{job}/download-circular', [CareerController::class, 'downloadCircular'])->name('careers.download.circular');

// Super admin only routes
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin/users/approval', [SuperAdminController::class, 'userApprovalList'])->name('admin.users.approval');
    Route::post('/admin/users/approve/{id}', [SuperAdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('/admin/users/unapprove/{id}', [SuperAdminController::class, 'unapproveUser'])->name('admin.users.unapprove');
    Route::post('/admin/users/block/{id}', [SuperAdminController::class, 'blockUser'])->name('admin.users.block');
    Route::post('/admin/users/unblock/{id}', [SuperAdminController::class, 'unblockUser'])->name('admin.users.unblock');
});

// User only routes
Route::middleware(['auth', 'approved', 'role:user'])->group(function () {
    Route::get('/dashboard', [BackendController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [BackendController::class, 'dashboard'])->name('dashboard');
    Route::get('/daily_work', [BackendController::class, 'dailywork'])->name('dashboard.daily_work');
    Route::post('/cases/{id}/update-hearing', [BackendController::class, 'updateCaseHearing'])->name('cases.update-hearing');
    Route::resource('addclient', AddclientController::class)->except(['edit', 'show']);
    Route::get('addclient/{id}/edit', [AddclientController::class, 'edit'])->name('addclient.edit');
    Route::get('addclient/{id}/show', [AddclientController::class, 'show'])->name('addclient.show');
    // Approval dashboard for user
    Route::get('addclient/approvals', [AddclientController::class, 'pendingApprovals'])->name('addclient.approvals');
    Route::post('addclient/approvals/{approval}/finalize', [AddclientController::class, 'finalizeApproval'])->name('addclient.approvals.finalize');
    Route::post('addclient/approvals/{approval}/reject', [AddclientController::class, 'rejectApproval'])->name('addclient.approvals.reject');
    Route::get('/client/export/pdf/{id}', [AddclientController::class, 'exportClientPdf'])->name('client.export.pdf');
    Route::get('/client/export/excel/{id}', [AddclientController::class, 'exportClientExcel'])->name('client.export.excel');
    Route::get('/needUpdateTransfer', [BackendController::class, 'needUpdateTransfer'])->name('needUpdateTransfer');
    Route::get('/todayUpdated', [BackendController::class, 'todayUpdated'])->name('todayUpdated');
    Route::get('/todayPrintcase', [BackendController::class, 'todayPrintcase'])->name('todayPrintcase');
    Route::get('/tomorrowPrintCase', [BackendController::class, 'tomorrowPrintCase'])->name('tomorrowPrintCase');
    // Route::get('/nexthearingcasePrint', [BackendController::class, 'nexthearingcasePrint'])->name('nexthearingcasePrint');
    Route::get('/exportNextHearingPdfPaginated', [BackendController::class, 'exportNextHearingPdfPaginated'])->name('exportNextHearingPdfPaginated');
    Route::get('/transfercasePrint', [BackendController::class, 'transfercasePrint'])->name('transfercasePrint');
    Route::resource('addcase', AddcaseController::class)->except(['edit', 'show']);
    Route::get('addcase/{id}/edit', [AddcaseController::class, 'caseedit'])->name('addcase.edit');
    Route::get('addcase/{id}/show', [AddcaseController::class, 'caseshow'])->name('addcase.show');
    Route::get('addcase/{id}/print', [AddcaseController::class, 'printSummary'])->name('addcase.print');
    // web.php
    Route::put('/addcase/{addcase}/ajax-update', [AddcaseController::class, 'ajaxUpdate'])
        ->name('addcase.ajax.update');
    Route::get('/addcase/{id}/edit-modal', [AddcaseController::class, 'editModal']);


    Route::get('/legalnotice/lndownload/{id}', [AddcaseController::class, 'lndownload'])->name('legalnotice.lndownload');
    Route::get('/plaints/pldownload/{id}', [AddcaseController::class, 'pldownload'])->name('plaints.pldownload');
    Route::get('/otherdocuments/othddownload/{id}', [AddcaseController::class, 'othddownload'])->name('otherdocuments.othddownload');
    Route::get('/legalnotice/olndownload/{id}', [AddcaseController::class, 'olndownload'])->name('legalnotice.olndownload');
    Route::get('/plaints/opldownload/{id}', [AddcaseController::class, 'opldownload'])->name('plaints.opldownload');
    Route::get('/otherdocuments/oothddownload/{id}', [AddcaseController::class, 'oothddownload'])->name('otherdocuments.oothddownload');

    // File Delete Routes
    Route::delete('/legalnotice/lndelete/{id}', [AddcaseController::class, 'lndelete'])->name('legalnotice.lndelete');
    Route::delete('/plaints/pldelete/{id}', [AddcaseController::class, 'pldelete'])->name('plaints.pldelete');
    Route::delete('/otherdocuments/othddelete/{id}', [AddcaseController::class, 'othddelete'])->name('otherdocuments.othddelete');
    Route::delete('/legalnotice/olndelete/{id}', [AddcaseController::class, 'olndelete'])->name('legalnotice.olndelete');
    Route::delete('/plaints/opldelete/{id}', [AddcaseController::class, 'opldelete'])->name('plaints.opldelete');
    Route::delete('/otherdocuments/oothddelete/{id}', [AddcaseController::class, 'oothddelete'])->name('otherdocuments.oothddelete');
    Route::get('caseHistory/{file_number}', [BackendController::class, 'caseHistory'])->name('caseHistory');
    Route::resource('stafflist', StafflistController::class);

    Route::get('/showMessage/{id}', [ContactController::class, 'showMessage'])->name('showMessage');
    Route::get('/messages/all', [ContactController::class, 'allMessages'])->name('messages.all');
    Route::post('/messages/mark-all-read', [ContactController::class, 'markAllMessagesRead'])->name('messages.markAllRead');
    Route::patch('/messages/{id}/notes', [ContactController::class, 'updateMessageNotes'])->name('messages.updateNotes');
    Route::delete('/messages/{id}', [ContactController::class, 'destroyMessage'])->name('messages.destroy');

    Route::resource('trustedclient', TrustedclientController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('imagegallery', ImagegalleryController::class);

    Route::get('/showSubscriber/{id}', [FrontendController::class, 'showSubscriber'])->name('showSubscriber');
    Route::delete('/subscribers/{id}', [FrontendController::class, 'destroySubscriber'])->name('subscribers.destroy');

    // Notifications routes
    Route::get('/notifications/all', [BackendController::class, 'allNotifications'])->name('notifications.all');
    Route::post('/notifications/mark-all-read', [BackendController::class, 'markAllNotificationsRead'])->name('notifications.markAllRead');

    // Job application routes
    Route::get('/job-applications/{id}', [CareerController::class, 'showApplication'])->name('job.applications.show');
    Route::patch('/job-applications/{id}/notes', [CareerController::class, 'updateApplicationNotes'])->name('job.applications.updateNotes');

    Route::get('/cases/export/pdf', [CaseExportController::class, 'exportPdf'])->name('cases.export.pdf');
    Route::get('/cases/export/excel', [CaseExportController::class, 'exportExcel'])->name('cases.export.excel');
    Route::get('/global-search', [GlobalSearchController::class, 'search'])->name('global.search');

    Route::resource('legalnoticecategories', LegalNoticeCategoryController::class)->except(['show', 'edit']);
    Route::get('legalnoticecategories/{id}/edit', [LegalNoticeCategoryController::class, 'edit'])->name('legalnoticecategories.edit');
    Route::get('legalnoticecategories/{id}/show', [LegalNoticeCategoryController::class, 'show'])->name('legalnoticecategories.show');

    // Legal Notice Pricing Routes
    Route::prefix('legalnotice')->name('legalnotice.')->group(function () {
        Route::resource('pricing', LegalNoticePricingController::class)->names('pricing');
        Route::get('/pricing/api/price', [LegalNoticePricingController::class, 'getPriceByClientAndCategory'])->name('pricing.getPrice');
    });

    Route::resource('legalnotice', LegalNoticeController::class);

    Route::get('/legalnotice/export/pdf', [LegalNoticeController::class, 'exportPdf'])->name('legalnotice.export.pdf');
    Route::get('/legalnotice/export/excel', [LegalNoticeController::class, 'exportExcel'])->name('legalnotice.export.excel');
    Route::put('/legalnotice/{id}/status', [LegalNoticeController::class, 'updateStatus'])->name('legalnotice.updateStatus');
    Route::get('/legal-notice-bill', [LegalNoticeController::class, 'legalnoticebill'])->name('legalnotice.bill');
    Route::post('/legal-notice/generate-bill-pdf', [LegalNoticeController::class, 'generateBillPdf'])->name('legalnotice.generateBillPdf');
    Route::get('/legal-notice/download-template', [LegalNoticeController::class, 'downloadTemplate'])->name('legalnotice.downloadTemplate');
    Route::post('/legal-notice/import', [LegalNoticeController::class, 'import'])->name('legalnotice.import');
    // Legal Notice Bill List
    Route::get('/legal-notice/bills', [LegalNoticeController::class, 'billIndex'])
        ->name('legalnotice.bills.index');

    // Download saved PDF
    Route::get('/legal-notice/bills/{id}/download', [LegalNoticeController::class, 'downloadBill'])
        ->name('legalnotice.bills.download');
    Route::get(
        '/legal-notice/bills/{id}/preview',
        [LegalNoticeController::class, 'previewBill']
    )->name('legalnotice.bills.preview');
    Route::delete(
        '/legal-notice/bills/{id}',
        [LegalNoticeController::class, 'deleteBill']
    )->name('legalnotice.bills.delete');


    // Edit Legal Notice Bill
    Route::get('/legal-notice/bills/{id}/edit', [LegalNoticeController::class, 'editBill'])->name('legalnotice.bills.edit');
    Route::put('/legal-notice/bills/{id}', [LegalNoticeController::class, 'updateBill'])->name('legalnotice.bills.update');

    // Auto-generate and download updated bill PDF
    Route::post('/legal-notice/bills/{id}/autopdf', [LegalNoticeController::class, 'autoGenerateBillPdf'])->name('legalnotice.bills.autopdf');


    Route::get('/export-next-hearing-pdf', [BackendController::class, 'exportneedUpdatePdfPaginated'])->name('exportneedUpdatePdfPaginated');
    Route::get('/export-next-hearing-excel', [BackendController::class, 'exportNeedUpdateExcel'])->name('exportNeedUpdateExcel');

    Route::resource('notes', NoteController::class);
    Route::put('/notes/{id}/status', [NoteController::class, 'updateStatus'])->name('notes.status');

    Route::resource('court_types', CourtTypeController::class);

    Route::get('/courts/export', [CourtController::class, 'courtexport'])->name('courts.export');
    Route::resource('courts', CourtController::class);
    Route::post('/courts/import', [CourtController::class, 'import'])->name('courts.import');
    Route::get('/courts/get-court-types', [CourtController::class, 'getCourtTypes'])->name('courts.getCourtTypes');

    Route::post('/addcase/update-excel', [AddcaseController::class, 'updateByExcel'])
        ->name('addcase.updateByExcel');

    // web.php
    Route::get('/case-history-bill', [CaseBillController::class, 'index'])->name('casehistory.bill.index');

    // routes/web.php
    Route::post('/casehistory/bill/pdf', [CaseBillController::class, 'generatePDF'])
        ->name('casehistory.bill.pdf');

    // ⬇ ClientBranch resource route (JSON CRUD)
    Route::resource('client-branches', ClientBranchController::class);
    // routes/web.php
    Route::get('/client-branch-page', [ClientBranchController::class, 'clientbranchpage'])->name('client.branch.page');



    Route::post('/casehistory/bill/pdf', [BillController::class, 'store'])->name('casehistory.bill.pdf');
    // optionally
    Route::post('/bill/generate', [BillController::class, 'store'])->name('casehistory.bill.store');

    Route::get('/case_bill/list', [BillController::class, 'casebilllist'])->name('case_bill.list');
    Route::get('/bill/preview/{bill}', [BillController::class, 'preview'])->name('bill.preview');
    Route::get('/bill/{bill}/edit', [BillController::class, 'edit'])->name('bill.edit');
    Route::put('/bill/{bill}', [BillController::class, 'update'])->name('bill.update');
    Route::delete('/bill/{bill}', [BillController::class, 'destroy'])->name('bill.destroy');
    // web.php
    Route::get('/bill/pdf/download/{bill}', [BillController::class, 'downloadPdf'])->name('bill.pdf.download');
    Route::get('/bill/pdf/view/{bill}', [BillController::class, 'viewPdf'])->name('bill.pdf.view');

    // Case History Management Routes
    Route::get('/addcase/history/{id}/edit', [AddcaseController::class, 'editHistory'])->name('addcase.history.edit');
    Route::put('/addcase/history/{id}/update', [AddcaseController::class, 'updateHistory'])->name('addcase.history.update');
    Route::delete('/addcase/history/{id}/delete', [AddcaseController::class, 'deleteHistory'])->name('addcase.history.delete');
    Route::resource('jobs', JobController::class);
    Route::get('jobs/{job}/applications', [JobController::class, 'applications'])->name('jobs.applications');
    Route::patch('applications/{application}/status', [JobController::class, 'updateApplicationStatus'])->name('applications.update.status');
    Route::get('applications/{application}/download-cv', [JobController::class, 'downloadCV'])->name('applications.download.cv');
});

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('manager/addclient/request/{id}/edit', [ManagerAddclientRequestController::class, 'edit'])->name('manager.addclient.request.edit');
    Route::post('manager/addclient/request/{id}/update', [ManagerAddclientRequestController::class, 'update'])->name('manager.addclient.request.update');
    Route::delete('manager/addclient/request/{id}/delete', [ManagerAddclientRequestController::class, 'destroy'])->name('manager.addclient.request.destroy');
    Route::get('manager/addclient/request/{id}/show', [ManagerAddclientRequestController::class, 'show'])->name('manager.addclient.request.show');
    Route::get('company-dashboard', [ManagerController::class, 'dashboard'])->name('manager.company.dashboard');
});
// Manager routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('managers', ManagerController::class)->only(['index', 'create', 'store']);
});

// Manager addclient request (pending approval)
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('manager/addclient/requests', [ManagerAddclientRequestController::class, 'index'])->name('manager.addclient.requests');
    Route::get('manager/addclient/rejected', [ManagerAddclientRequestController::class, 'rejected'])->name('manager.addclient.rejected');
    Route::get('manager/addclient/request', [ManagerAddclientRequestController::class, 'create'])->name('manager.addclient.request.create');
    Route::post('manager/addclient/request', [ManagerAddclientRequestController::class, 'store'])->name('manager.addclient.request.store');
});

// Manager approvals: view pending addclient requests
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('manager/approvals/addclients', [\App\Http\Controllers\ManagerApprovalController::class, 'pendingAddclients'])->name('manager.approvals.addclients');
});

require __DIR__ . '/auth.php';

<div class="modal fade" id="modalSchedule">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Schedule online with us!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table align-middle text-break">
                    <tbody id="listItem">
                        <form id="formSchedule">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="scheduleFirstname" class="form-label">Firstname <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="scheduleFirstname" name="scheduleFirstname" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="scheduleLastname" class="form-label">Lastname <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="scheduleLastname" name="scheduleLastname" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="schedulePhone" class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="phone" class="form-control" id="schedulePhone" name="schedulePhone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="scheduleEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="scheduleEmail" name="scheduleEmail" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="scheduleDate" class="form-label">Select date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="scheduleDate" name="scheduleDate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="scheduleTime" class="form-label">Select time <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="scheduleTime" name="scheduleTime" required></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="scheduleService" class="form-label">Services <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="scheduleService" name="scheduleService" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-bg-1" id="btnMessage" >Schedule</button>
                                <button type="button" class="btn btn-bg-2 text-white" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
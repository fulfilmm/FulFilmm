<!-- Edit Ticket Modal -->
<div id="edit_ticket" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ticket Subject</label>
                                <input class="form-control" type="text" value="Laptop Issue">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ticket Id</label>
                                <input class="form-control" type="text" readonly value="TKT-0001">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Assign Staff</label>
                                <select class="select">
                                    <option>-</option>
                                    <option selected>Mike Litorus</option>
                                    <option>John Smith</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="select">
                                    <option>-</option>
                                    <option >Delta Infotech</option>
                                    <option selected>International Software Inc</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Priority</label>
                                <select class="select">
                                    <option>High</option>
                                    <option selected>Medium</option>
                                    <option>Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>CC</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Assign</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ticket Assignee</label>
                                <div class="project-members">
                                    <a title="John Smith" data-placement="top" data-toggle="tooltip" href="#" class="avatar">
                                        <img src="img/profiles/avatar-02.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Add Followers</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ticket Followers</label>
                                <div class="project-members">
                                    <a href="" id="appen"></a>
                                    <a title="Richard Miles" data-toggle="tooltip" href="#" class="avatar">
                                        <img src="img/profiles/avatar-09.jpg" alt="">
                                    </a>
                                    <a title="John Smith" data-toggle="tooltip" href="#" class="avatar">
                                        <img src="img/profiles/avatar-10.jpg" alt="">
                                    </a>
                                    <a title="Mike Litorus" data-toggle="tooltip" href="#" class="avatar">
                                        <img src="img/profiles/avatar-05.jpg" alt="">
                                    </a>
                                    <a title="Wilmer Deluna" data-toggle="tooltip" href="#" class="avatar">
                                        <img src="img/profiles/avatar-11.jpg" alt="">
                                    </a>
                                    <span class="all-team">+2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Upload Files</label>
                                <input class="form-control" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Ticket Modal -->

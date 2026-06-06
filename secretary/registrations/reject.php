<div class="modal fade" id="rejectModal<?= $row['user_id'] ?>" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Reject Registration

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="reject_user_id" value="<?= $row['user_id'] ?>">

                    <div class="mb-3">

                        <label class="form-label">

                            Remarks

                        </label>

                        <textarea name="remarks" class="form-control" rows="4" required></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" class="btn btn-danger">

                        Reject

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

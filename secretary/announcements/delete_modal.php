<!-- DELETE MODAL -->
<div class="modal fade" id="delete<?= $row['id'] ?>" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST">

                <input type="hidden" name="id" value="<?= $row['id'] ?>">

                <div class="modal-header">

                    <h5 class="modal-title text-danger">

                        Delete Announcement

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-danger">

                        Are you sure you want to delete:

                        <strong>
                            <?= htmlspecialchars($row['title']) ?>
                        </strong>?

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" name="delete_announcement" class="btn btn-danger">

                        <i class="bi bi-trash"></i>
                        Delete

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="edit<?= $row['id'] ?>" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST">

                <input type="hidden" name="id" value="<?= $row['id'] ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Announcement
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Title
                        </label>

                        <input type="text" name="title" class="form-control"
                            value="<?= htmlspecialchars($row['title']) ?>" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Content
                        </label>

                        <textarea name="content" rows="5" class="form-control"
                            required><?= htmlspecialchars($row['content']) ?></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-select">

                            <option value="Published" <?= $row['status'] === 'Published' ? 'selected' : '' ?>>

                                Published

                            </option>

                            <option value="Draft" <?= $row['status'] === 'Draft' ? 'selected' : '' ?>>

                                Draft

                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" name="update_announcement" class="btn btn-primary">

                        <i class="bi bi-pencil-square"></i>
                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

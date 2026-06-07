<!-- VIEW MODAL -->
<div class="modal fade" id="viewModal<?= $row['user_id'] ?>" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    <i class="bi bi-person-lines-fill"></i>
                    Resident Registration Details
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

            </div>

            <!-- BODY -->
            <div class="modal-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="text-muted">Full Name</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars(
                                $row['first_name'] . ' ' .
                                $row['middle_name'] . ' ' .
                                $row['last_name'] . ' ' .
                                $row['suffix']
                            ) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Household No</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['household_no']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Gender</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['gender']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Birth Date</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['birth_date']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Civil Status</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['civil_status']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Contact No</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['contact_no']) ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="text-muted">Address</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['address']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Occupation</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['occupation']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Citizenship</label>
                        <div class="fw-bold">
                            <?= htmlspecialchars($row['citizenship']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Account Status</label>
                        <div>
                            <?php if ($row['status'] === 'Approved'): ?>
                                <span class="badge bg-success">Approved</span>
                            <?php elseif ($row['status'] === 'Pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Registered At</label>
                        <div class="fw-bold">
                            <?= date('M d, Y h:i A', strtotime($row['created_at'])) ?>
                        </div>
                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">

                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>

            </div>

        </div>

    </div>

</div>

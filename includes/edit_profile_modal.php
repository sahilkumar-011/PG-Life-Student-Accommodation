<div class="modal fade" id="edit-profile-modal" tabindex="-1" role="dialog" aria-labelledby="edit-profile-heading" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-profile-heading">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="edit-profile-form" class="form" role="form" method="post" action="api/update_profile.php">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="full_name" placeholder="Full Name" maxlength="30" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-phone-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="phone" placeholder="Phone Number" maxlength="10" minlength="10" value="<?= htmlspecialchars($user['phone']) ?>" required>
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="New Password (leave blank to keep current)" minlength="6">
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-university"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="college_name" placeholder="College Name" maxlength="150" value="<?= htmlspecialchars($user['college_name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <span>I'm a</span>
                        <input type="radio" class="ml-3" id="edit-gender-male" name="gender" value="male" <?= $user['gender'] == 'male' ? 'checked' : '' ?> />
                        <label for="edit-gender-male">Male</label>
                        <input type="radio" class="ml-3" id="edit-gender-female" name="gender" value="female" <?= $user['gender'] == 'female' ? 'checked' : '' ?> />
                        <label for="edit-gender-female">Female</label>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="note" placeholder="Note (optional)" maxlength="500" rows="3"><?= htmlspecialchars($user['note'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

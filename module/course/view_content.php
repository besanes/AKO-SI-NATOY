<section class="content">

	<!-- BRUCE SOLUTIONS -->

	<div class="container-fluid">

		<?php check_message(); ?>

		<div class="row">
			<div class="col-md-4">
				<div class="card card-outline card-primary">
					<div class="card-body box-profile text-center">
						<i class="fas fa-graduation-cap fa-5x text-primary mb-3"></i>

						<h3 class="profile-username text-center">
							<?php echo htmlspecialchars($course->COURSE_CODE); ?>
						</h3>

						<p class="text-muted text-center">
							<?php echo htmlspecialchars($course->COURSE_NAME); ?>
						</p>

						<p class="text-center">
							<?php if ($course->STATUS == 'Active'): ?>
								<span class="badge badge-success">Active</span>
							<?php else: ?>
								<span class="badge badge-secondary">Inactive</span>
							<?php endif; ?>
						</p>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->

			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Course Information</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<table class="table table-bordered">
							<tr>
								<th style="width: 30%">Course Code</th>
								<td><?php echo htmlspecialchars($course->COURSE_CODE); ?></td>
							</tr>
							<tr>
								<th>Course Name</th>
								<td><?php echo htmlspecialchars($course->COURSE_NAME); ?></td>
							</tr>
							<tr>
								<th>Description</th>
								<td><?php echo nl2br(htmlspecialchars($course->COURSE_DESC)); ?></td>
							</tr>
							<tr>
								<th>Status</th>
								<td>
									<?php if ($course->STATUS == 'Active'): ?>
										<span class="badge badge-success">Active</span>
									<?php else: ?>
										<span class="badge badge-secondary">Inactive</span>
									<?php endif; ?>
								</td>
							</tr>
						</table>

						<a href="index.php" class="btn btn-secondary">
							<i class="fas fa-arrow-left"></i> Back to List
						</a>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

	</div>
	<!-- /.container-fluid -->
</section>

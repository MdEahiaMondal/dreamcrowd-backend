<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">

<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900" rel="stylesheet" type="text/css">
	<style>
		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			padding: 0;
		}

		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: inherit !important;
		}

		#MessageViewBody a {
			color: inherit;
			text-decoration: none;
		}

		p {
			line-height: inherit
		}

		@media (max-width:640px) {
			.mobile_hide {
				display: none;
			}

			.row-content {
				width: 100% !important;
			}

			.stack .column {
				width: 100%;
				display: block;
			}
		}
	</style>
</head>

<body class="body" style="background-color: #e6e6e6; margin: 0; padding: 0;">
	<table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e6e6e6;">
		<tbody>
			<tr>
				<td>
					<!-- Header with Logo -->
					<table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
						<tbody>
							<tr>
								<td>
									<table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ffffff; width: 620px; margin: 0 auto;" width="620">
										<tbody>
											<tr>
												<td class="column column-1" width="100%" style="padding: 20px; text-align: center;">
													<img src="https://6246f85385.imgdist.com/pub/bfra/aqt02fag/eki/ejv/mae/navlogo.png" alt="Logo" height="auto" width="212" style="display: block; margin: 0 auto;">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>

					<!-- Main Content -->
					<table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
						<tbody>
							<tr>
								<td>
									<table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ffffff; width: 620px; margin: 0 auto;" width="620">
										<tbody>
											<tr>
												<td class="column column-1" width="100%" style="padding: 40px 20px;">

													<!-- Alert Icon -->
													<div style="text-align: center; margin-bottom: 20px;">
														<div style="display: inline-block; background-color: #ffc107; border-radius: 50%; width: 80px; height: 80px; line-height: 80px; font-size: 40px;">
															⏰
														</div>
													</div>

													<!-- Heading -->
													<h1 style="margin: 0 0 20px 0; color: #393d47; font-family: Montserrat, sans-serif; font-size: 28px; font-weight: 700; text-align: center;">
														Your Trial Class Starts Soon!
													</h1>

													<!-- Message -->
													<p style="margin: 0 0 20px 0; color: #393d47; font-family: Montserrat, sans-serif; font-size: 16px; line-height: 150%; text-align: center;">
														Hi {{$userName}},<br><br>
														Your {{$isFree ? 'free' : 'paid'}} trial class starts in <strong>30 minutes</strong>!
													</p>

													<!-- Class Details Box -->
													<div style="background-color: #f8f9fa; border-radius: 10px; padding: 25px; border: 1px solid #e1e4e8; margin: 20px 0;">
														<table width="100%" cellpadding="0" cellspacing="0" style="color: #393d47; font-family: Montserrat, sans-serif; font-size: 15px;">
															<tr>
																<td style="padding: 8px 0;"><strong>Class:</strong></td>
																<td style="padding: 8px 0; text-align: right;">{{$classTitle}}</td>
															</tr>
															<tr>
																<td style="padding: 8px 0;"><strong>Teacher:</strong></td>
																<td style="padding: 8px 0; text-align: right;">{{$teacherName}}</td>
															</tr>
															<tr>
																<td style="padding: 8px 0;"><strong>Start Time:</strong></td>
																<td style="padding: 8px 0; text-align: right; color: #d32f2f; font-weight: 600;">{{$classDateTime}}</td>
															</tr>
															<tr>
																<td style="padding: 8px 0;"><strong>Duration:</strong></td>
																<td style="padding: 8px 0; text-align: right;">{{$duration}}</td>
															</tr>
															<tr>
																<td style="padding: 8px 0;"><strong>Timezone:</strong></td>
																<td style="padding: 8px 0; text-align: right;">{{$timezone}}</td>
															</tr>
														</table>
													</div>

													<!-- Zoom Link Button -->
													<div style="text-align: center; margin: 30px 0;">
														<a href="{{$meetingLink}}" target="_blank" style="background-color: #2D8CFF; border-radius: 8px; color: #ffffff; display: inline-block; font-family: Montserrat, sans-serif; font-size: 18px; font-weight: 600; padding: 15px 40px; text-align: center; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
															🎥 Join Zoom Meeting
														</a>
													</div>

													<!-- Meeting Link Text -->
													<p style="margin: 20px 0; color: #666; font-family: Montserrat, sans-serif; font-size: 13px; text-align: center;">
														Or copy and paste this link in your browser:<br>
														<a href="{{$meetingLink}}" style="color: #0072b1; word-break: break-all;">{{$meetingLink}}</a>
													</p>

													<!-- Tips Section -->
													<div style="background-color: #e3f2fd; border-left: 4px solid #2196f3; padding: 15px; margin: 25px 0;">
														<p style="margin: 0 0 10px 0; color: #1565c0; font-family: Montserrat, sans-serif; font-size: 14px; font-weight: 600;">
															💡 Quick Tips:
														</p>
														<ul style="margin: 0; padding-left: 20px; color: #393d47; font-family: Montserrat, sans-serif; font-size: 14px; line-height: 160%;">
															<li>Test your camera and microphone before joining</li>
															<li>Find a quiet place with good internet connection</li>
															<li>Join a few minutes early to avoid any technical issues</li>
														</ul>
													</div>

													<!-- Footer Message -->
													<p style="margin: 25px 0 0 0; color: #666; font-family: Montserrat, sans-serif; font-size: 14px; text-align: center;">
														We hope you enjoy your trial class!<br>
														If you have any issues, please contact us immediately.
													</p>

												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>

					<!-- Footer -->
					<table class="row row-3" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
						<tbody>
							<tr>
								<td>
									<table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f5f5f5; width: 620px; margin: 0 auto;" width="620">
										<tbody>
											<tr>
												<td class="column column-1" width="100%" style="padding: 20px; text-align: center;">
													<p style="margin: 0; color: #999; font-family: Montserrat, sans-serif; font-size: 12px;">
														© {{date('Y')}} DreamCrowd. All rights reserved.
													</p>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>

				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>

<?php
/********************************************************************************/
// update plugin settings
if ($_POST['appvitrineAction']=='applySettings'){
	
	// general settings
	update_option('appvitrine_publication_id', stripslashes($_POST['appvitrine_publication_id']));
	update_option('appvitrine_gs_iTunes_affiliate_id', stripslashes($_POST['appvitrine_gs_iTunes_affiliate_id']));
	//update_option('appvitrine_gs_useCategoriesByDefault', isset($_POST['appvitrine_gs_useCategoriesByDefault']));
	update_option('appvitrine_gs_onlyMobile', $_POST['appvitrine_gs_onlyMobile']);

	//show in all pages settings
	update_option('appvitrine_df_enable', $_POST['appvitrine_df_enable']);
	update_option('appvitrine_df_type', $_POST['appvitrine_df_type']);
	update_option('appvitrine_df_format', $_POST['appvitrine_df_format']);
	update_option('appvitrine_df_postContentTag', $_POST['appvitrine_df_postContentTag']);

	//shortcode settings
	update_option('appvitrine_sc_defaultFormat', $_POST['appvitrine_sc_defaultFormat']);
	update_option('appvitrine_sc_defaultType', $_POST['appvitrine_sc_defaultType']);
	update_option('appvitrine_sc_useTagsByDefault', isset($_POST['appvitrine_sc_useTagsByDefault']));
	
}
?>



<div class="wrap appvitrin">
	<h2 id="add-new-user" style="margin-left:25px">
		AppVitrine :: Settings
	</h2>
	<br>
	<form action="" method="post" name="appvitrinsetting" id="appvitrinsetting" class="validate">
		
		<input name="appvitrineAction" type="hidden" value="applySettings" />
		
		<div class="sction_border" >
		<fieldset>

			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row" style="width:300px;">
							<label for="appvitrine_gs_onlyMobile" style="display: block;margin-top: -7px;">
								Show the app slider only on mobile devices
							</label>
						</th>
						<td>
							<label for="" >
								<input 
									name="appvitrine_gs_onlyMobile" 
									type="checkbox" 
									id="appvitrine_gs_onlyMobile" 
									value="1"
									<?php echo (get_option("appvitrine_gs_onlyMobile")=='')?"":"checked" ?>>
							</label>
						</td>	
					</tr>
					<tr class="form-field">
						<th scope="row" style="width:300px;">
							<label for="appvitrine_publication_id">
								Quantaad Publication ID
								<span class="description">
									(optional) <br>  Don't you have a Quantaad publication ID?<br> <a href="http://portal.quantaad.com/membership/security/#/membership/security/signup/publisher" target="_blank">Apply for one here</a> 
								</span>
							</label>
						</th>
						<td>
							<input name="appvitrine_publication_id" type="text" id="appvitrine_publication_id" value="<?php echo get_option('appvitrine_publication_id'); ?>"
							aria-required="true" />
						</td>
					</tr>
					<tr class="form-field">
						<th scope="row" style="width:300px;">
							<label for="appvitrine_gs_iTunes_affiliate_id">
								iTunes affiliate ID
								<span class="description">
									(optional)<br>  Don't you have an iTunes affiliate ID? <br> <a href="https://www.apple.com/itunes/affiliates/resources/" target="_blank"> Apply for one here</a>
								</span>
							</label>
						</th>
						<td>
							<input name="appvitrine_gs_iTunes_affiliate_id" type="text" id="appvitrine_gs_iTunes_affiliate_id" value="<?php echo get_option('appvitrine_gs_iTunes_affiliate_id'); ?>"
							aria-required="true" />
						</td>
					</tr>
				</tbody>
			</table>	
		</fieldset>
		</div>
		
		<br>
		<div class="sction_border">
		<fieldset>
			<legend>
				
				<div style="  display: inline-table;vertical-align: middle;  margin-top: 3px;">
					<input 
						name="appvitrine_df_enable" 
						type="checkbox" 
						id="appvitrine_df_enable" <?php echo (get_option("appvitrine_df_enable")=='')?"":"checked" ?> >
				</div>
				<div class="text" style="  display: inline-table;vertical-align: middle; ">
					<label for="appvitrine_df_enable">ADD APPVITRINE TO THE END OF ALL POSTS</label>
				</div>
			</legend>
			<div id="add_to_all">
			<table class="form-table" >
				<tbody>
					<tr>
						<th scope="row" style="width:300px;vertical-align:middle;text-align: center;">
							<label id="appvitrine_df_format_label" for="appvitrine_df_format">
									Format:
							</label>
						</th>
						<td>
							<input type="hidden" id="appvitrine_df_format" name="appvitrine_df_format" value="<?php echo get_option("appvitrine_df_format") ?>" />
							<table>
								<tr>
									<td>
										<img 
											class="appvitrine_df_format <?php echo (get_option("appvitrine_df_format")=="" || get_option("appvitrine_df_format")=="icon-f1" )?"active":"" ?>"
											data-format="icon-f1"
											src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/icon-f1_w250.png' ?>" />
									</td>
									<td  style="display:none">
										<img
											class="appvitrine_df_format <?php echo (get_option("appvitrine_df_format")=="slider-f1" )?"active":"" ?>"
											data-format="slider-f1" 	
											src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/slider-f1_w250.png' ?>" />
									</td>
								</tr>
								<tr>								
									<td>
										<img 
											class="appvitrine_df_format <?php echo (get_option("appvitrine_df_format")=="slider-f2" )?"active":"" ?>"
											data-format="slider-f2"
											src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/slider-f2_w250.png' ?>" />
									</td>
								</tr>
								<tr>	
									<td>
										<img
											class="appvitrine_df_format <?php echo (get_option("appvitrine_df_format")=="slider-f3" )?"active":"" ?>"
											data-format="slider-f3" 
											src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/slider-f3_w250.png' ?>" />
									</td>
								</tr>
							</table>	
						</td>	
					</tr>
					<tr  style="display:none">
						<th scope="row" style="width:300;text-align: center;">
							<label for="appvitrine_df_type">
									Type:
							</label>
						</th>
						<td>
							<select  id="appvitrine_df_type" name="appvitrine_df_type">
								<option value="slider" <?php echo (get_option("appvitrine_df_type")=='slider')?"selected":"" ?>>
									Slider
								</option>
								<option value="link" <?php echo (get_option("appvitrine_df_type")=='link')?"selected":"" ?>>
									Link
								</option>
								<option value="button" <?php echo (get_option("appvitrine_df_type")=='button')?"selected":"" ?>>
									Button
								</option>
							</select>	
						</td>	
					</tr>
					<tr>
						<th scope="row" style="width:300px;text-align: center;vertical-align:middle;">
							<label for="appvitrine_df_postContentKeyword">
								Relevancy:
							</label>
						</th>
						<td>
							<label>
								<input 
									name="appvitrine_df_postContentTag" 
									type="radio" 
									id="appvitrine_df_postContentTag1" 
									value="1"
									<?php echo (get_option("appvitrine_df_postContentTag")=='' || get_option("appvitrine_df_postContentTag")=='1')?"checked":"" ?>>
									<span>Show apps related to only the posts' content</span>
							</label>
							<br/>
							<label>
								<input 
									name="appvitrine_df_postContentTag" 
									type="radio" 
									id="appvitrine_df_postContentTag2" 
									value="2"
									<?php echo (get_option("appvitrine_df_postContentTag")=='2')?"checked":"" ?>>
									<span>Show apps related to only the posts' tags (if available)</span>
							</label>
							<br/>
							<label>
								<input 
									name="appvitrine_df_postContentTag" 
									type="radio" 
									id="appvitrine_df_postContentTag3" 
									value="3"
									<?php echo (get_option("appvitrine_df_postContentTag")=='3')?"checked":"" ?>>
									<span>Show apps related to both posts' content and posts' tags (if available)</span>
							</label>
						</td>	
					</tr>
				</tbody>
			</table>	
			</div>
		</fieldset>
		</div>
		<br>
		
		<div class="sction_border" style="display:none">
		<fieldset>
			<legend>
				<a class="btn-toggle" data-target=".advance-settings">
					<div style="  display: inline-table;vertical-align: middle;">
						<img src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/plus.png' ?>" class="small-btn btn-expand"  />
						<img src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/min.png' ?>" class=" small-btn btn-colapse"  style="display:none;" />
					</div>
					<div class="text" style="  display: inline-table;vertical-align: middle; ">
						<lable>ADVANCED SETTINGS (SHORTCODE DEFAULTS)</lable>
					
					</div>
				</a>
			</legend>
			<table class="form-table advance-settings" style="display:none;" >
				<tbody>					
					<tr class="form-field form-required">
						<th scope="row" style="width:300px;vertical-align:middle;text-align: center;">
							<label for="appvitrine_sc_defaultFormat">
								Default "format" of shortcodes:
							</label>
						</th>
						<td>
							<input type="hidden" id="appvitrine_sc_defaultFormat" name="appvitrine_sc_defaultFormat" value="<?php echo get_option("appvitrine_sc_defaultFormat") ?>" />
							<table>
								<tr>
									<td>
										<img 
											class="appvitrine_sc_defaultFormat <?php echo (get_option("appvitrine_sc_defaultFormat")=="" || get_option("appvitrine_sc_defaultFormat")=="icon-f1" )?"active":"" ?>"
											data-format="icon-f1"
											src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/icon-f1_w250.png' ?>" />
									</td>
									<td>
										<img
											class="appvitrine_sc_defaultFormat <?php echo (get_option("appvitrine_sc_defaultFormat")=="slider-f1" )?"active":"" ?>"
											data-format="slider-f1" 	
											src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/slider-f1_w250.png' ?>" />
									</td>
								</tr>
								<tr>
									<td>
										<img 
											class="appvitrine_sc_defaultFormat <?php echo (get_option("appvitrine_sc_defaultFormat")=="slider-f2" )?"active":"" ?>"
											data-format="slider-f2"
											src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/slider-f2_w250.png' ?>" />
									</td>
									<td>
										<img
											class="appvitrine_sc_defaultFormat <?php echo (get_option("appvitrine_sc_defaultFormat")=="slider-f3" )?"active":"" ?>"
											data-format="slider-f3" 
											src="<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/slider-f3_w250.png' ?>" />
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr class="form-field form-required">
						<th scope="row" style="width:300px;text-align: center;">
							<label for="appvitrine_sc_defaultType">
								Default "type" of shortcodes:
							</label>
						</th>
						<td>
							<select  id="appvitrine_sc_defaultType" name="appvitrine_sc_defaultType">
								<option value="slider" <?php echo (get_option("appvitrine_sc_defaultType")=='slider' || get_option("appvitrine_sc_defaultType")=="")?"selected":"" ?> >
									Slider
								</option>
								<option value="link" <?php echo (get_option("appvitrine_sc_defaultType")=='link')?"selected":"" ?>>
									Link
								</option>
								<option value="button" <?php echo (get_option("appvitrine_sc_defaultType")=='button')?"selected":"" ?>>
									Button
								</option>
							</select>	
						</td>
					</tr>
					
					<tr>
						<th scope="row" style="width:300px;text-align: center;">
							<label for="appvitrine_sc_useTagsByDefault">
								Use post's tags as keywords in shortcode if no keyword is provided manually
							</label>
						</th>
						<td>
							<label for="">
								<input 
									name="appvitrine_sc_useTagsByDefault" 
									type="checkbox" 
									id="appvitrine_sc_useTagsByDefault" 
									value="1"
									<?php echo (get_option("appvitrine_sc_useTagsByDefault")=='')?"":"checked" ?>>
							</label>
						</td>	
					</tr>
				</tbody>
			</table>
		</fieldset>
		</div>
		
		
		<p class="submit">
			<input type="submit" name="apply" id="apply" class="button button-primary" value="Apply">
		</p>
	</form>
</div>
<script>
	(function($){
		
		function check(){
			var checked=!$("#appvitrine_df_enable").prop("checked");
			$("#appvitrine_df_size").prop( "disabled", checked );
			$("#appvitrine_df_type").prop( "disabled", checked );
			/*$("#appvitrine_gs_onlyMobile").prop( "disabled", checked );*/
			$("#appvitrine_df_postContentTag1").prop( "disabled", checked );
			$("#appvitrine_df_postContentTag2").prop( "disabled", checked );
			$("#appvitrine_df_postContentTag3").prop( "disabled", checked );
			if(!checked){
				$("#add_to_all").attr( "style", "display:block" );
			}
			else{
				$("#add_to_all").attr( "style", "display:none" );
			}
		}
		
		$("#appvitrine_df_enable").change(function(){
			check();	
		});
		
		$(document).ready(function(){
			check();
		});
		
		/**************************************/
		$(".appvitrine_sc_defaultFormat").click(function(){
			$(".appvitrine_sc_defaultFormat").removeClass("active");
			
			$(this).addClass("active");
			$("#appvitrine_sc_defaultFormat").val($(this).attr("data-format"));
		});
		$(".appvitrine_df_format").click(function(){
			$(".appvitrine_df_format").removeClass("active");
			
			$(this).addClass("active");
			$("#appvitrine_df_format").val($(this).attr("data-format"));
		});
		
		$(".btn-toggle").click(function(){
			var target=$(this).attr("data-target");
			if ($(target).hasClass("expand")){
				$(this).find("img.btn-colapse").hide();
				$(this).find("img.btn-expand").show();
				$(target).removeClass("expand");
				$(target).slideUp(200);
			}else{
				$(this).find("img.btn-colapse").show();
				$(this).find("img.btn-expand").hide();
				$(target).addClass("expand");
				$(target).slideDown(200);
			}
		});
		
		$(":checkbox").each(function(){
			
			var imgCheck=$("<img class='small-btn' src='<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/check.png' ?>'>");
			var imgUnCheck=$("<img class='small-btn' src='<?php echo WP_PLUGIN_URL . '/'. basename(__DIR__).'/img/circle.png' ?>' >");
			
			var checkbox=$(this);
			imgCheck.insertBefore($(this));
			imgUnCheck.insertBefore($(this));
			$(this).hide();
			
			
			
			function setValue(){
				if (checkbox.prop("checked")){
					imgCheck.show();
					imgUnCheck.hide();					
				}else{
					imgCheck.hide();
					imgUnCheck.show();
				}
			}
			
			checkbox.change(function(){
				setValue();
			})
			imgCheck.click(function(){
				$(checkbox).prop('checked', false).change();
			});
			imgUnCheck.click(function(){
				$(checkbox).prop('checked', true).change();
			});
			setValue();
			
		});
		
	})(jQuery)
</script>
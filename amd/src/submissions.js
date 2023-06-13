/**
 *  * plagiarism_originality submissions.
 *  *
 *  * @package    plagiarism_originality
 *  * @copyright  2023 mattandor <mattan@centricapp.co>
 *  * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *  */

define(['jquery'],
    function ($) {
        return {
            unsetLimit: function () {
                var attemptreopenmethod = $('#id_attemptreopenmethod'),
                    maxattempts = $('#id_maxattempts');

                attemptreopenmethod.find('option').removeAttr('disabled');
                maxattempts.find('option').removeAttr('disabled');
            },
            setLimit: function () {
                var attemptreopenmethod = $('#id_attemptreopenmethod'),
                    maxattempts = $('#id_maxattempts');

                attemptreopenmethod.find('option').attr('disabled', true);
                attemptreopenmethod.find('[value=manual]').prop('selected', true).removeAttr('disabled');
                attemptreopenmethod.change().click();

                maxattempts.find('option').attr('disabled', true);
                maxattempts.find('[value=2]').prop('selected', true).removeAttr('disabled');
                maxattempts.change().click();
            },
            submissions: function () {

                var that = this;
                var originality_dropdown = $('#id_originality_use'),
                    originality_dropdown_ghostwriter = $('#id_originality_use_ghostwriter'),
                    submit_button = $('input[id=id_submitbutton], input[id=id_submitbutton2]'),
                    originality_status = originality_dropdown.val(),
                    allow_files_ghostwriter = '.rtf,.docx,.doc';

                // ghostwriter Init
                var el = $('#fitem_fgroup_id_assignsubmission_file_filetypes'),
                    ghostinit = setInterval(function () {
                        {
                            if (originality_dropdown_ghostwriter.val() == 1) {
                                el.find('[type=text]').val(allow_files_ghostwriter).attr('readonly', true);
                                el.find('[type=button]').attr('disabled', true);
                            }
                            if (el.find('[type=button]').length > 0)
                                clearInterval(ghostinit);
                        }
                    }, 2000);

                originality_dropdown_ghostwriter.change(function () {
                    var base = $(this),
                        status = base.val();

                    if (status == 1) {
                        el.find('[type=text]').val(allow_files_ghostwriter).attr('readonly', true);
                        el.find('[type=button]').attr('disabled', true);
                        // notify(true);
                    } else {
                        el.find('[type=text]').removeAttr('readonly');
                        el.find('#id_assignsubmission_file_filetypes').val('*');
                        el.find('[type=button]').removeAttr('disabled');
                    }
                });

                if (originality_status == 2)
                    that.setLimit();

                originality_dropdown.change(function () {
                    var base = $(this),
                        status = base.val(),
                        msg = $('#assignment_has_submissions_notifications');

                    if (status == 2)
                        that.setLimit();
                    else
                        that.unsetLimit();

                    if (status == 1) {
                        $('.originality-message').toggle(true);

                        if (msg.length) {
                            require(['core/notification'], function (notification) {
                                notification.alert('Notification', msg.html(), 'OK');
                            });
                        }
                    }
                });
                submit_button.on('click', function (e) {
                    var is_onlinetext = $('#id_assignsubmission_onlinetext_enabled').is(':checked'),
                        is_gw_on = $('#id_originality_use_ghostwriter').val();

                    if (is_onlinetext && is_gw_on == 1 && $('.originality-gw-notify').length) {
                        e.preventDefault();
                        require(['core/notification'], function (notification) {
                            notification.alert('', $('.core-notification msg').text(), $('.core-notification btn').text());
                        });
                    }
                });

                if ($('#originality-checkbox').length) {
                    $('#region-main input[id=id_submitbutton]').click(function (e) {
                        var isChecked = $('#originality-checkbox').is(':checked');
                        if (!isChecked) {
                            e.preventDefault();
                            require(['core/notification'], function (notification) {
                                notification.alert('Originality Warning', $('.core-notification msg').text(), $('.core-notification btn').text());
                            });
                            return;
                        }
                    });

                    $('#region-main #originality-checkbox').click(function (e) {
                        var isChecked = $(this).is(':checked');
                        $('.originality-checkbox-form').remove();
                        $('.mform').prepend('<input type="hidden" value="' + isChecked + '" class="originality-checkbox-form" name="originality-checkbox-form">');
                    });
                }
            }
        };
    });
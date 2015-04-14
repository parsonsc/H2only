var smartDonationsEditCampaign;

rnJQuery(function()
{
    var smartDonationsCampaignDialog=rnJQuery('#smart-donations-add-new-campaign-panel').dialog({
        modal:true,
        autoOpen:false,
        width:'530px',
        create: function(event, ui){
            rnJQuery('.ui-dialog').wrap('<div class="smartDonationsSlider" />');
        },
        open: function(event, ui){
            rnJQuery('.ui-widget-overlay').wrap('<div class="smartDonationsSlider" />');
            rnJQuery(".smartDonationsConfigurationFields").val('');
        }

    });


    rnJQuery("#sDonationsAddNew").click(function(event)
    {
        event.preventDefault();


        OpenCreateDialog();
    });

    function ClearDialog()
    {
        rnJQuery("#smart_donations_campaign_name").val(''),
        rnJQuery("#smart_donations_campaign_description").val(''),
        rnJQuery("#smart_donations_campaign_goal").val(0);
        rnJQuery("#smartDonationsThankYouEmail").val('');
        rnJQuery("#smartDonationsEmailSubject").val('');
        rnJQuery('#smartDonationsSendThankYouEmail').removeAttr('checked');

        DisableThankYouEmail();
    }


    function OpenCreateDialog()
    {
        smartDonationsCampaignDialog.dialog('open');
        smartDonationsCampaignDialog.dialog("option","title","Create Campaign");

        rnJQuery("#campaignSaveButton").unbind("click").click(function()
        {
           rnJQuery(this).attr('disabled', 'disabled');
            var data={
                action:"rednao_smart_donations_add_campaign",
                name:rnJQuery("#smart_donations_campaign_name").val(),
                description:rnJQuery("#smart_donations_campaign_description").val(),
                goal:rnJQuery("#smart_donations_campaign_goal").val(),
                thank_you_email:rnJQuery('#smartDonationsThankYouEmail').val(),
                email_subject:rnJQuery('#smartDonationsEmailSubject').val()
            };

            rnJQuery.post(ajaxurl,data,ajaxCompleted);
        });


    }

    function ajaxCompleted(result)
    {
        rnJQuery("#campaignSaveButton").removeAttr('disabled');
        if(result=="success")
        {
            alert('Campaign saved successfully');
            location.reload();
        }else
        {
            alert(result);
        }
    }


    function OpenEditDialog(campaign) {
        ClearDialog();
        smartDonationsCampaignDialog.dialog('open');
        smartDonationsCampaignDialog.dialog("option","title","Edit Campaign");

        rnJQuery("#campaignSaveButton").unbind("click").click(function()
        {
            rnJQuery(this).attr('disabled', 'disabled');
            var data={
                action:"rednao_smart_donations_edit_campaign",
                campaign_id:campaign.campaign_id,
                name:rnJQuery("#smart_donations_campaign_name").val(),
                description:rnJQuery("#smart_donations_campaign_description").val(),
                thank_you_email:rnJQuery('#smartDonationsThankYouEmail').val(),
                goal:rnJQuery("#smart_donations_campaign_goal").val(),
                email_subject:rnJQuery('#smartDonationsEmailSubject').val()
            };

            rnJQuery.post(ajaxurl,data,ajaxCompleted);
        });

        rnJQuery("#smart_donations_campaign_name").val(campaign.name),
        rnJQuery("#smart_donations_campaign_description").val(campaign.description),
        rnJQuery("#smart_donations_campaign_goal").val(campaign.goal);
        rnJQuery("#smartDonationsThankYouEmail").val(campaign.thank_you_email);
        rnJQuery("#smartDonationsEmailSubject").val(campaign.email_subject);

        if(campaign.email_subject||campaign.thank_you_email)
            rnJQuery('#smartDonationsSendThankYouEmail').attr('checked','checked');
        else
            rnJQuery('#smartDonationsSendThankYouEmail').removeAttr('checked');


        if(rnJQuery("#smartDonationsThankYouEmail").val())
            EnableThankYouEmail();
    }


    function EditCampaign(id)
    {


        for(var i=0;i<smartDonationsCampaignArray.length;i++)
        {
            if(smartDonationsCampaignArray[i].campaign_id==id)
            {
                OpenEditDialog(smartDonationsCampaignArray[i]);
            }
        }
    }

    smartDonationsEditCampaign=EditCampaign;





    /************************************************************************************* Thank You Email Code ***************************************************************************************************/
    rnJQuery('#smartDonationsSendThankYouEmail').change(SendThankYouEmailChanged);

    function SendThankYouEmailChanged()
    {
        if(rnJQuery('#smartDonationsSendThankYouEmail').is(':checked'))
            EnableThankYouEmail();
        else
            DisableThankYouEmail();


    }

    function EnableThankYouEmail()
    {
        rnJQuery('#smartDonationsThankYouEmail').removeAttr('disabled');
        rnJQuery('#smartDonationsThankYouEmail').css('background-color','#fff');

        rnJQuery('#smartDonationsEmailSubject').removeAttr('disabled');
        rnJQuery('#smartDonationsEmailSubject').css('background-color','#fff');

    }

    function DisableThankYouEmail()
    {
        rnJQuery('#smartDonationsThankYouEmail').attr('disabled','disabled');
        rnJQuery('#smartDonationsThankYouEmail').css('background-color','#ddd');
        rnJQuery('#smartDonationsThankYouEmail').val('');

        rnJQuery('#smartDonationsEmailSubject').attr('disabled','disabled');
        rnJQuery('#smartDonationsEmailSubject').css('background-color','#ddd');
        rnJQuery('#smartDonationsEmailSubject').val('');
    }


});



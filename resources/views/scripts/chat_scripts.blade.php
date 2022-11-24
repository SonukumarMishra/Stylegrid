<script>

    /**
     *-------------------------------------------------------------
    * Global variables
    *-------------------------------------------------------------
    */
    var messenger,
        typingTimeout,
        typingNow = 0,
        temporaryMsgId = 0,
        defaultAvatarInSettings = null,
        messengerColor,
        dark_mode,
        messages_page = 1;

    const messagesContainer = $(".messenger-messagingView .m-body"),
        messengerTitleDefault = $(".messenger-headTitle").text(),
        messageInput = $("#message-form .m-send"),
        defaultMessengerColor = "#2180f3",
        access_token = $('meta[name="csrf-token"]').attr("content");

        console.log(chat_baseurl);
    const getMessengerId = () => $("meta[name=id]").attr("content");
    const getMessengerType = () => $("meta[name=type]").attr("content");
    const setMessengerId = (id) => $("meta[name=id]").attr("content", id);
    const setMessengerType = (type) => $("meta[name=type]").attr("content", type);
    
    /**
     *-------------------------------------------------------------
    * Re-usable methods
    *-------------------------------------------------------------
    */
    const escapeHtml = (unsafe) => {
                                    return unsafe
                                        .replace(/&/g, "&amp;")
                                        .replace(/</g, "&lt;")
                                        .replace(/>/g, "&gt;");
                                    };

    /**
     *-------------------------------------------------------------
    * Pusher channels and event listening..
    *-------------------------------------------------------------
    */

    // subscribe to the channel
    // var channel = pusher.subscribe("private-chatify");

    // // Listen to messages, and append if data received
    // channel.bind("messaging", function (data) {
    //     if (data.from_id == getMessengerId() && data.to_id == auth_id) {
    //         $(".messages").find(".message-hint").remove();
    //         messagesContainer.find(".messages").append(data.message);
    //         scrollToBottom(messagesContainer);
    //         makeSeen(true);
    //         // remove unseen counter for the user from the contacts list
    //         $(".messenger-list-item[data-contact=" + getMessengerId() + "]")
    //         .find("tr>td>b")
    //         .remove();
    //     }
    // });

    
    // loading placeholder for users list item
    function listItemLoading(items) {
        let template = "";
        for (let i = 0; i < items; i++) {
            template += `
            <div class="loadingPlaceholder">
            <div class="loadingPlaceholder-wrapper">
            <div class="loadingPlaceholder-body">
            <table class="loadingPlaceholder-header">
            <tr>
            <td style="width: 45px;"><div class="loadingPlaceholder-avatar"></div></td>
            <td>
                <div class="loadingPlaceholder-name"></div>
                    <div class="loadingPlaceholder-date"></div>
            </td>
            </tr>
            </table>
            </div>
            </div>
            </div>
            `;
        }
        return template;
    }


    let contactsPage = 1;
    let contactsLoading = false;
    let noMoreContacts = false;

    function setContactsLoading(loading = false) {
        if (!loading) {
            $(".listOfContacts").find(".loading-contacts").remove();
        } else {
            $(".listOfContacts").append(
            `<div class="loading-contacts">${listItemLoading(4)}</div>`
            );
        }
        contactsLoading = loading;
    }

    function getContacts() {
        if (!contactsLoading && !noMoreContacts) {
            setContactsLoading(true);
            $.ajax({
                url: chat_baseurl + "messanger/getContacts",
                method: "POST",
                data: { _token: access_token, page: contactsPage },
                dataType: "JSON",
                success: (response) => {
                    console.log(response);

                    setContactsLoading(false);

                    if(response.status = 1){

                        if(response.data.lenth > 0){
                            
                            $(".listOfContacts").html(data.contacts);

                        }else{
                            $(".listOfContacts").html('<p class="message-hint center-el"><span>Your contact list is empty</span></p>');
                        }
                    }
                    return;

                    updateSelectedContact();
                    // update data-action required with [responsive design]
                    cssMediaQueries();
                    // Pagination lock & messages page
                    noMoreContacts = contactsPage >= data?.last_page;
                    if (!noMoreContacts) contactsPage += 1;
                },
                error: (error) => {
                    setContactsLoading(false);
                    console.error(error);
                },
            });
        }
    }

    function getContactsUIHtml(contacts) {

        var html = '';

        if(contacts.lenth > 0){

            $.each(contacts, function (i, val) { 
                
                html += '<table class="messenger-list-item" data-contact="">';
                html +=     '<tr data-action="0">';
            });
    
        }

        return html;
    }
    
    $(document).ready(function () {
    
        // get contacts list
        getContacts();
    
    });

</script>
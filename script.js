$(document).ready(function() {
    $("#send-button").on("click", function() {
        sendMessage();
    });

    $("#user-input").on("keypress", function(event) {
        if (event.key === "Enter") {
            sendMessage();
        }
    });

    function sendMessage() {
        var userInput = $("#user-input").val();
        if (userInput.trim() === "") return;

        // Add user's message to the chat log as a line
        var userLine = "<div class='chat-line user-line'>" + userInput + "</div>";
        $("#chat-log").append(userLine);

        $.ajax({
            url: "chatbot.php",
            type: "POST",
            data: { user_input: userInput },
            success: function(response) {
                // Add assistant's reply to the chat log as a line
                var assistantLine = "<div class='chat-line assistant-line'>" + response + "</div>";
                $("#chat-log").append(assistantLine);

                // Clear user input and scroll to the bottom
                $("#user-input").val("");
                $("#chat-log").scrollTop($("#chat-log")[0].scrollHeight);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
});

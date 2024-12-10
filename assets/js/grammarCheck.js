document.addEventListener("DOMContentLoaded", function () {
  // Handler for Objective button
  document
    .getElementById("checkGrammarObjective")
    .addEventListener("click", function () {
      const text = document.querySelector('textarea[name="objective"]').value;
      checkGrammar(text, "grammarSuggestions");
    });

  // Handler for Job Description button
  document
    .getElementById("checkGrammarJobDesc")
    .addEventListener("click", function () {
      const text = document.querySelector('textarea[name="job_desc"]').value;
      checkGrammar(text, "grammarSuggestionsJobDesc");
    });
});

// Grammar check function
function checkGrammar(text, suggestionContainerId) {
  const suggestionContainer = document.getElementById(suggestionContainerId);

  // Clear previous suggestions and show a loading message
  suggestionContainer.innerText = "Checking grammar...";

  if (!text.trim()) {
    suggestionContainer.innerText = "Text is empty.";
    return;
  }

  // Send the text to the backend for grammar checking
  fetch("actions/checkGrammar.action.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      text: text,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      // Clear the loading message
      suggestionContainer.innerHTML = "";

      // Check if grammar matches are returned
      if (data.matches && data.matches.length > 0) {
        // Display each grammar issue
        data.matches.forEach((match) => {
          const message = match.message;
          const context = match.context.text;
          const offset = match.offset;
          const length = match.length;
          const replacement = match.replacements[0]?.value || "No suggestion";

          // Highlight the issue
          const highlightedText = `<span style="color: red; font-weight: bold;">${context.substring(
            offset,
            offset + length
          )}</span>`;
          suggestionContainer.innerHTML += `
                <div>
                    <strong>Issue:</strong> ${message}<br>
                    <strong>Suggestion:</strong> Replace <em>${highlightedText}</em> with <strong>${replacement}</strong>.
                </div><hr>`;
        });
      } else {
        suggestionContainer.innerHTML = "<div>No grammar issues found!</div>";
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      suggestionContainer.innerHTML =
        "<div>Error checking grammar. Please try again later.</div>";
    });
}

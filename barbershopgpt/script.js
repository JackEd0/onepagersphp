document.addEventListener("DOMContentLoaded", () => {
  const title = document.getElementById("title");
  const heroText = document.getElementById("heroText");
  const servicesList = document.getElementById("servicesList");
  const hours = document.getElementById("hours");
  const address = document.getElementById("address");
  const googleMap = document.getElementById("googleMap");
  const languageSwitcher = document.getElementById("languageSwitcher");

  let currentLanguage = "en";
  let contentData = {};

  // Load JSON content
  fetch("data/content.json")
      .then(response => response.json())
      .then(data => {
          contentData = data.content;
          updateContent();
      });

  // Update website content based on language
  function updateContent() {
      const content = contentData[currentLanguage];

      title.textContent = content.title;
      heroText.textContent = content.hero;
      hours.textContent = content.hours;
      address.textContent = content.contact.address;
      googleMap.src = content.contact.map_embed;

      servicesList.innerHTML = "";
      content.services.forEach(service => {
          const serviceCard = `
              <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
                  <img src="${service.image}" alt="${service.name}" class="w-full h-40 object-cover rounded-lg mb-2">
                  <h3 class="text-lg font-bold">${service.name}</h3>
                  <p class="text-gray-700">${service.description}</p>
                  <p class="text-green-500 font-bold">${service.price}</p>
              </div>
          `;
          servicesList.innerHTML += serviceCard;
      });
  }

  // Language Switcher
  languageSwitcher.addEventListener("change", (e) => {
      currentLanguage = e.target.value;
      updateContent();
  });
});

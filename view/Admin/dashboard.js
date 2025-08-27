 const monthYear = document.getElementById("month-year");
  const daysContainer = document.getElementById("calendar-days");
  let date = new Date();

  function renderCalendar() {
    daysContainer.innerHTML = "";
    let year = date.getFullYear();
    let month = date.getMonth();

     let today = new Date();
 
    
    monthYear.textContent = date.toLocaleString("default", { month: "long", year: "numeric" });
    
    let firstDay = new Date(year, month, 1).getDay();
    let lastDate = new Date(year, month + 1, 0).getDate();
    
    // Fill empty spaces
    for (let i = 0; i < firstDay; i++) {
      daysContainer.innerHTML += `<div></div>`;
    }
    
    // Fill days
    for (let day = 1; day <= lastDate; day++) {
      daysContainer.innerHTML += `<div class="day">${day}</div>`;
      
    }

    document.querySelectorAll(".day").forEach(d => {
      d.addEventListener("click", () => {
        document.querySelectorAll(".day").forEach(el => el.classList.remove("selected"));
        d.classList.add("selected");
      });
    });
  }

  document.getElementById("prev").addEventListener("click", () => {
    date.setMonth(date.getMonth() - 1);
    renderCalendar();
  });

  document.getElementById("next").addEventListener("click", () => {
    date.setMonth(date.getMonth() + 1);
    renderCalendar();
  });

  renderCalendar();
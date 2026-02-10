
document.addEventListener("DOMContentLoaded", function () {
  const bs = window.bootstrap;
  if (bs) {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => { try { new bs.Tooltip(el); } catch (_) {} });
  }

  const DELIM = "```";
  const sel = {
    t: 'input[name="secTitle_rows[]"]',
    s: 'input[name="secSTitle_rows[]"]',
    d: 'textarea[name="secDescrption_rows[]"]',
  };
  const hid = {
    t: document.getElementById("secTitleHidden"),
    s: document.getElementById("secSTitleHidden"),
    d: document.getElementById("secDescrptionHidden"),
  };

  function trimEnds(arr) {
    const out = arr.slice();
    while (out.length && out[0].trim() === "") out.shift();
    while (out.length && out[out.length - 1].trim() === "") out.pop();
    return out;
  }

  function syncServiceHidden() {
    const tVals = Array.from(document.querySelectorAll(sel.t)).map(el => (el.value || "").trim());
    const sVals = Array.from(document.querySelectorAll(sel.s)).map(el => (el.value || "").trim());
    const dVals = Array.from(document.querySelectorAll(sel.d)).map(el => (el.value || "").trim());

    if (hid.t) hid.t.value = trimEnds(tVals).join(DELIM);
    if (hid.s) hid.s.value = trimEnds(sVals).join(DELIM);
    if (hid.d) hid.d.value = trimEnds(dVals).join(DELIM);
  }

  document.addEventListener("input", (e) => {
    if (e.target.matches(sel.t) || e.target.matches(sel.s) || e.target.matches(sel.d)) {
      syncServiceHidden();
    }
  });

  document.getElementById("addServiceRow")?.addEventListener("click", () => {
    const body = document.getElementById("serviceSectionBody");
    if (!body) return;
    const tr = document.createElement("tr");
    tr.className = "service-row";
    tr.innerHTML = `
      <td><input type="text" class="form-control" name="secTitle_rows[]" placeholder="An Overview of One Person Company (OPC)"></td>
      <td><input type="text" class="form-control" name="secSTitle_rows[]" placeholder="Introduction / Benefits / Documentation / Package offers / Guide"></td>
      <td><textarea class="form-control" rows="3" name="secDescrption_rows[]" placeholder="<p>HTML block for this row...</p>"></textarea></td>
      <td class="text-center">
        <button type="button" class="btn btn-outline-danger btn-sm remove-service-row" data-bs-toggle="tooltip" title="Remove row">
          <i class="bi bi-trash3"></i>
        </button>
      </td>
    `;
    body.appendChild(tr);
    if (bs) { const t = tr.querySelector('[data-bs-toggle="tooltip"]'); if (t) new bs.Tooltip(t); }
    syncServiceHidden();
  });

  document.addEventListener("click", (e) => {
    const rm = e.target.closest(".remove-service-row");
    if (rm) {
      const tr = rm.closest("tr");
      const body = tr?.parentElement;
      if (body && body.querySelectorAll("tr").length > 1) {
        tr.remove();
        syncServiceHidden();
      }
    }
  });

  syncServiceHidden();
  document.getElementById("addNewFaq")?.addEventListener("click", () => {
    const tbody = document.getElementById("faqTableBody");
    if (!tbody) return;
    const tr = document.createElement("tr");
    tr.className = "faq-row";
    tr.innerHTML = `
      <td><input type="text" name="faq_titles[]" class="form-control" placeholder="Enter your question..." required></td>
      <td><textarea name="faq_contents[]" class="form-control" rows="2" placeholder="Provide a detailed answer..." required></textarea></td>
      <td class="text-center">
        <button type="button" class="btn btn-outline-danger btn-sm remove-faq" data-bs-toggle="tooltip" title="Remove FAQ">
          <i class="bi bi-trash3"></i>
        </button>
      </td>
    `;
    tbody.appendChild(tr);
    if (bs) { const t = tr.querySelector('[data-bs-toggle="tooltip"]'); if (t) new bs.Tooltip(t); }
  });

  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".remove-faq");
    if (!btn) return;
    const row = btn.closest("tr");
    const tbody = document.getElementById("faqTableBody");
    if (tbody && row && tbody.children.length > 1) row.remove();
  });

  const seoTitle = document.getElementById("seo_title");
  const seoTitleHint = document.getElementById("seo_title_hint");
  const seoDesc = document.getElementById("seo_description");
  const seoDescHint = document.getElementById("seo_desc_hint");

  if (seoTitle && seoTitleHint) {
    const update = () => {
      const len = seoTitle.value.length;
      seoTitleHint.textContent = `Recommended: 50–60 characters • ${len}/60`;
      seoTitleHint.className = len > 60 ? "form-text text-danger" : "form-text";
    };
    seoTitle.addEventListener("input", update);
    update();
  }

  if (seoDesc && seoDescHint) {
    const update = () => {
      const len = seoDesc.value.length;
      seoDescHint.textContent = `Recommended: 150–160 characters • ${len}/160`;
      seoDescHint.className = len > 160 ? "form-text text-danger" : "form-text";
    };
    seoDesc.addEventListener("input", update);
    update();
  }

  const fpLib = window.flatpickr;
  const offerInput = document.getElementById("offer_dates");
  const selectedDatesText = document.getElementById("selectedDatesText");
  const clearBtn = document.getElementById("clearOfferDates");
  let fp = null;

  if (fpLib && offerInput) {
    fp = fpLib(offerInput, {
      mode: "range",
      dateFormat: "m/d/Y",
      minDate: "today",
      showMonths: window.innerWidth > 768 ? 2 : 1,
      prevArrow: '<i class="bi bi-chevron-left"></i>',
      nextArrow: '<i class="bi bi-chevron-right"></i>',
      locale: { rangeSeparator: " - " },
      onChange(dates) {
        if (!selectedDatesText) return;
        if (dates.length === 2) {
          const fmt = d => d.toLocaleDateString("en-US", { year: "numeric", month: "short", day: "numeric" });
          selectedDatesText.innerHTML = `<strong class="text-success">${fmt(dates[0])} to ${fmt(dates[1])}</strong>`;
        } else if (dates.length === 1) {
          selectedDatesText.innerHTML = `<em class="text-warning">Select end date...</em>`;
        } else {
          selectedDatesText.innerHTML = '<span class="text-muted">None</span>';
        }
      },
    });

    clearBtn?.addEventListener("click", () => {
      fp.clear();
      if (selectedDatesText) selectedDatesText.innerHTML = '<span class="text-muted">None</span>';
    });

    window.addEventListener("resize", () => { if (fp) fp.set("showMonths", window.innerWidth > 768 ? 2 : 1); });
  }
});

function generateSlug() {
  const nameEl = document.getElementById("name");
  const slugEl = document.getElementById("slug");
  if (!nameEl || !slugEl) return;
  const slug = nameEl.value
    .toLowerCase()
    .replace(/[^a-z0-9 -]/g, "")
    .replace(/\s+/g, "-")
    .replace(/-+/g, "-")
    .replace(/^-+|-+$/g, "");
  slugEl.value = slug;
}

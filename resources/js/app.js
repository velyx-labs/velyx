import "./utils/clipboard";
import accordion from "./ui/accordion";
import alert from "./ui/alert";
import input from "./ui/input";
import tabs from "./ui/tabs";
import dropdownMenu from "./ui/dropdown-menu";
import commandPalette from "./ui/command-palette";
import drawer from "./ui/drawer";
import datePicker from "./ui/date-picker";
import fileUpload from "./ui/file-upload";
import dialog from "./ui/dialog";
import rating from "./ui/rating";
import toast from "./ui/toast";
import popover from "./ui/popover";
import rangeSlider from "./ui/range-slider";
import stepper from "./ui/stepper";
import timeline from "./ui/timeline";
import tooltip from "./ui/tooltip";
import toggle from "./ui/toggle";
import sortableList from "./ui/sortable-list/list";
import sortableListItem from "./ui/sortable-list/item";
import Alpine from "alpinejs";
import Prism from "prismjs";
import "prismjs/components/prism-markup";
import "prismjs/components/prism-markup-templating";
import "prismjs/components/prism-bash";
import "prismjs/components/prism-css";
import "prismjs/components/prism-javascript";
import "prismjs/components/prism-jsx";
import "prismjs/components/prism-typescript";
import "prismjs/components/prism-tsx";
import "prismjs/components/prism-json";
import "prismjs/components/prism-yaml";
import "prismjs/components/prism-php";
import "prismjs/components/prism-markdown";

function initDarkMode() {
    const toggles = document.querySelectorAll(".dark-mode-toggle");
    if (!toggles.length) return;

    const savedTheme = localStorage.getItem("theme");
    const systemDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    const isDarkInitial = savedTheme === "dark" || (!savedTheme && systemDark);
    document.documentElement.classList.toggle("dark", isDarkInitial);

    toggles.forEach((toggle) => {
        toggle.addEventListener("click", (event) => {
            const isDark = document.documentElement.classList.contains("dark");
            const newTheme = isDark ? "light" : "dark";
            const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

            const applyThemeChange = () => {
                document.documentElement.classList.toggle("dark");
                localStorage.setItem("theme", newTheme);
            };

            if (!prefersReducedMotion && document.startViewTransition) {
                const { clientX: x, clientY: y } = event;
                const root = document.documentElement;

                root.style.setProperty("--x", `${x}px`);
                root.style.setProperty("--y", `${y}px`);
                document.startViewTransition(() => applyThemeChange());
            } else {
                applyThemeChange();
            }
        });
    });
}

function initCodeCopyButtons() {
    const codeBlocks = document.querySelectorAll(".prose pre");

    codeBlocks.forEach((block) => {
        if (!(block instanceof HTMLElement)) return;
        if (block.querySelector(".copy-button") || block.closest(".no-copy-button")) return;

        const button = document.createElement("button");
        button.className =
            "copy-button cursor-pointer absolute top-2 right-2 p-2 rounded-md bg-muted hover:bg-muted-foreground/20 text-muted-foreground hover:text-foreground transition-opacity opacity-50 group-hover:opacity-100";
        button.innerHTML =
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>';
        button.setAttribute("aria-label", "Copy code");

        block.classList.add("group");
        block.classList.add("markdown-viewer__code-block");

        button.addEventListener("click", async () => {
            const code = block.querySelector("code");
            const text = code?.textContent ?? "";

            try {
                await navigator.clipboard.writeText(text);
                button.classList.add("bg-green-500", "text-white");
                button.innerHTML =
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';

                setTimeout(() => {
                    button.classList.remove("bg-green-500", "text-white");
                    button.innerHTML =
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>';
                }, 2000);
            } catch (error) {
                console.error("Failed to copy:", error);
            }
        });

        block.appendChild(button);
    });
}

function initDocsUi() {
    initDarkMode();
    void initDocSearch();
    Prism.highlightAll();
    initCodeCopyButtons();
}

async function initDocSearch() {
  const docsearchContainer = document.getElementById("docsearch");
  if (!docsearchContainer) return;

  const appId = docsearchContainer.dataset.appId;
  const indexName = docsearchContainer.dataset.indexName;
  const apiKey = docsearchContainer.dataset.apiKey;

  if (!appId || !indexName || !apiKey) return;

  const { default: docsearch } = await import("@docsearch/js");

  docsearch({
    container: "#docsearch",
    appId,
    indexName,
    apiKey,
    placeholder: "Search docs…",
    translations: {
      button: {
        buttonText: "Search",
        buttonAriaLabel: "Search documentation",
      },
      modal: {
        searchBox: {
          resetButtonTitle: "Clear the query",
          cancelButtonText: "Close",
          cancelButtonAriaLabel: "Close search",
        },
      },
    },
  });
}

async function initCodeHighlighting() {
  const codeBlocks = document.querySelectorAll("pre code");
  if (!codeBlocks.length) return;

  const Prism = (await import("prismjs")).default;

  await Promise.all([
    import("prismjs/components/prism-markup"),
    import("prismjs/components/prism-markup-templating"),
    import("prismjs/components/prism-bash"),
    import("prismjs/components/prism-css"),
    import("prismjs/components/prism-javascript"),
    import("prismjs/components/prism-jsx"),
    import("prismjs/components/prism-typescript"),
    import("prismjs/components/prism-tsx"),
    import("prismjs/components/prism-json"),
    import("prismjs/components/prism-yaml"),
    import("prismjs/components/prism-php"),
    import("prismjs/components/prism-markdown"),
  ]);

  Prism.highlightAll();
}
document.addEventListener("alpine:init", () => {
    console.log("Init: ");
    Alpine.data("sortableList", sortableList);
    Alpine.data("sortableListItem", sortableListItem);
    Alpine.data("toggle", toggle);
    Alpine.data("tooltip", tooltip);
    Alpine.data("timeline", timeline);
    Alpine.data("stepper", stepper);
    Alpine.data("rangeSlider", rangeSlider);
    Alpine.data("dropdownMenu", dropdownMenu);
    Alpine.data("alert", alert);
    // initDarkMode();
    Alpine.data("input", input);
    Alpine.data("tabs", tabs);
    Alpine.data("accordion", accordion);
    Alpine.data("commandPalette", commandPalette);
    Alpine.data("drawer", drawer);
    Alpine.data("datePicker", datePicker);
    Alpine.data("fileUpload", fileUpload);
    Alpine.data("dialog", dialog);
    Alpine.data("rating", rating);
    Alpine.data("toast", toast);
    Alpine.data("popover", popover);
});
document.addEventListener("DOMContentLoaded", function () {
  initDarkMode();
  void initDocSearch();
  void initCodeHighlighting();
  const codeBlocks = document.querySelectorAll(".prose pre");

  codeBlocks.forEach((block) => {
    // Skip if already has a button or has no-copy-button class
    if (block.querySelector(".copy-button") || block.closest(".no-copy-button"))
      return;

    const button = document.createElement("button");
    button.className =
      "copy-button cursor-pointer absolute top-2 right-2 p-2 rounded-md bg-muted hover:bg-muted-foreground/20 text-muted-foreground hover:text-foreground transition-opacity opacity-50 group-hover:opacity-100";
    button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>`;
    button.setAttribute("aria-label", "Copy code");

    // Add group class to parent for hover effect
    block.classList.add("group");

    button.addEventListener("click", async () => {
      const code = block.querySelector("code");
      const text = code.textContent;

      try {
        await navigator.clipboard.writeText(text);
        button.classList.add("bg-green-500", "text-white");
        button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;

        setTimeout(() => {
          button.classList.remove("bg-green-500", "text-white");
          button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>`;
        }, 2000);
      } catch (err) {
        console.error("Failed to copy:", err);
      }
    });

    block.appendChild(button);
  });

  // Show button on hover
  const style = document.createElement("style");
  style.textContent = `
        .prose pre.group:hover .copy-button,
        .prose pre .copy-button:focus {
            opacity: 1 !important;
        }
    `;
  document.head.appendChild(style);
});

document.addEventListener("DOMContentLoaded", initDocsUi);
document.addEventListener("livewire:navigated", initDocsUi);

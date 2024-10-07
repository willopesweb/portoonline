import { createNotification } from "./notification";

interface Email {
  email: string;
  message: string;
  name: string;
  subject: string;
  captcha?: string;
  captchaCode?: string;
}

interface Comment {
  postId: string;
  comment: string;
  name: string;
  userId: string;
  userEmail: string;
  parent?: string;
  captcha?: string;
  captchaCode?: string;
}

const forms = document.querySelectorAll(".js-form");

if (forms) {
  forms.forEach((form) => {
    form.addEventListener("submit", handleSubmit);
  });
}

async function handleSubmit(this: HTMLElement, e: Event) {
  e.preventDefault();

  const formData = new FormData(e.target as HTMLFormElement);
  const formDataObject: Record<string, string> = {};

  formData.forEach((value, key) => {
    formDataObject[key] = value as string;
  });

  let message = "";
  let DataToSend: Email | Comment;

  if (this.id === "comment") {
    DataToSend = {
      postId: formDataObject.PostId,
      name: formDataObject.Nome,
      comment: formDataObject.Comentario,
      userId: formDataObject.UserId,
      userEmail: formDataObject.Email,
      parent: formDataObject.ParentId,
      captcha: formDataObject.Captcha,
      captchaCode: formDataObject.CaptchaCode,
    };
  } else {
    for (const key in formDataObject) {
      if (key !== "Captcha" && key !== "CaptchaCode") {
        message += `<b>${key}: </b>${formDataObject[key]}<br/>`;
      }
    }

    DataToSend = {
      email: formDataObject.Email,
      message: message,
      name: formDataObject.Nome,
      subject:
        this.id === "anuncio"
          ? "Novo pedido de anúncio enviado pelo site"
          : `${formDataObject.Nome} enviou uma mensagem pelo site!`,
      captcha: formDataObject.Captcha,
      captchaCode: formDataObject.CaptchaCode,
    };
  }

  console.log(formDataObject);
  console.log(DataToSend);
  submitContent(this, DataToSend);
}

async function submitContent(form: HTMLElement, EmailData: Email | Comment) {
  const loading = form.querySelector(".c-loading");
  loading?.classList.add("is-visible");

  try {
    const result = await sendEmail(EmailData);
    //console.log(result);
    if (result.success) {
      createNotification(result.message as string, "success");
      if (result.reload) {
        setTimeout(() => {
          let url = window.location.href;
          if (form.id === "commentsList") {
            if (url.endsWith("/")) url = url.slice(0, -1);
            window.location.href = `${window.location.href.split("#")[0]
              }#commentList`;
          }
          window.location.reload();
        }, 2000);
      }
    } else {
      createNotification(`${result.error}`, "error");
    }
  } catch (error) {
    console.error("Erro na solicitação de envio de e-mail:", error);
    createNotification("Erro ao enviar e-mail", "error");
  }
  loading?.classList.remove("is-visible");
}

async function sendEmail(formData: Email | Comment): Promise<{
  success: boolean;
  error?: string;
  message?: string;
  reload?: boolean | undefined;
}> {
  try {
    const response = await fetch(`${window.location.origin}/wp-send-mail.php`, {
      method: "POST",
      body: JSON.stringify(formData),
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (response.ok) {
      const { message, reload } = await response.json();
      return { success: true, message, reload };
    } else {
      const errorResponse = await response.json();
      return {
        success: false,
        error: errorResponse.message, // || "Erro desconhecido",
      };
    }
  } catch (error) {
    console.error("Erro na solicitação de envio de e-mail:", error);
    return { success: false, error: "Erro desconhecido" };
  }
}

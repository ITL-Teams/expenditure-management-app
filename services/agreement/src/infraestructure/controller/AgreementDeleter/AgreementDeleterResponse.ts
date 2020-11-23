export type AgreementDeleterResponse = {
  success?: {
    message: string
  }
  error?: {
    message: string
    reason: string
  }
}

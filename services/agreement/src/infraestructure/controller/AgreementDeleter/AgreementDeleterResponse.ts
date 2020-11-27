export type AgreementDeleterResponse = {
  success?: {
    deleted: boolean
  }
  error?: {
    message: string
    reason: string
  }
}

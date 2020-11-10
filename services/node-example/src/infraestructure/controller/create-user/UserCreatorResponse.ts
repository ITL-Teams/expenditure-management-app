export type UserCreatorResponse = {
  success?: {
    message: string
    id: string
  }
  error?: {
    message: string
    reason: string
  }
}
